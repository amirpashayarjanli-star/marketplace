<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Customer;
use App\Models\ServiceContract;
use App\Models\Technician;
use App\Models\User;
use App\Services\ServiceContractService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| پرونده و قرارداد از سمت ادمین
|--------------------------------------------------------------------------
|
| مشتری‌ای که تلفنی تماس می‌گیرد حسابی روی سایت ندارد، پس تا امروز هیچ
| راهی نبود که پرونده‌اش را ثبت کنیم. اینجا ادمین همان کاری را می‌کند که
| مشتری در service/buildings انجام می‌داد.
|
| حساب کاربر با همان موبایل ساخته می‌شود تا مشتری بعداً بتواند با کد
| پیامکی وارد شود و پرونده‌اش را ببیند — ورود با رمز چون رمزش تصادفی
| است کار نمی‌کند، ولی ورود با کد پیامکی رمز نمی‌خواهد.
|
*/
class AdminBuildingController extends Controller
{
    public function __construct(
        private ServiceContractService $contracts,
    ) {
    }


    public function create()
    {
        return view('admin.buildings.create', [
            'provinces' => config('provinces', []),
        ]);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([

            'customer_mobile' => 'required|regex:/^09[0-9]{9}$/',
            'customer_name'   => 'required|string|min:3|max:255',
            'customer_phone'  => 'nullable|string|max:30',

            'title'          => 'required|string|max:150',
            'province'       => 'nullable|string|max:60',
            'city'           => 'nullable|string|max:60',
            'address'        => 'required|string|max:500',
            'postal_code'    => 'nullable|string|max:20',
            'floors'         => 'nullable|integer|min:0|max:200',
            'units'          => 'nullable|integer|min:0|max:2000',
            'manager_name'   => 'nullable|string|max:120',
            'manager_mobile' => 'nullable|string|max:20',
            'notes'          => 'nullable|string|max:1000',

            'elevators'                => 'nullable|array|max:20',
            'elevators.*.label'        => 'nullable|string|max:120',
            'elevators.*.brand'        => 'nullable|string|max:120',
            'elevators.*.capacity_kg'  => 'nullable|integer|min:0|max:10000',
            'elevators.*.stops'        => 'nullable|integer|min:0|max:200',
            'elevators.*.install_year' => 'nullable|integer|min:1300|max:1500',
            'elevators.*.serial_no'    => 'nullable|string|max:120',

        ], [], [
            'customer_mobile' => 'موبایل مشتری',
            'customer_name'   => 'نام مشتری',
            'customer_phone'  => 'تلفن ثابت مشتری',
            'title'           => 'نام ساختمان',
            'province'        => 'استان',
            'city'            => 'شهر',
            'address'         => 'آدرس',
            'postal_code'     => 'کد پستی',
            'floors'          => 'تعداد طبقات',
            'units'           => 'تعداد واحدها',
            'manager_name'    => 'نام مدیر ساختمان',
            'manager_mobile'  => 'موبایل مدیر ساختمان',
            'notes'           => 'توضیحات',
        ]);


        $existing = User::where('mobile', $validated['customer_mobile'])->first();

        /*
        | اگر این شماره حساب کسب‌وکار باشد، ساختن پروفایل مشتری رویش
        | حساب را دوپاره می‌کند: میان‌افزار approved او را به ویزارد
        | کسب‌وکار می‌فرستد ولی پرونده‌اش زیر پروسرویس است.
        */
        if ($existing && $existing->type && $existing->type !== 'customer') {

            return back()
                ->withInput()
                ->with('error', 'این شماره متعلق به حساب «' . $existing->type . '» است. پرونده فقط روی حساب مشتری ساخته می‌شود.');

        }


        [$customer, $accountCreated] = DB::transaction(function () use ($validated, $existing) {

            $user = $existing ?? User::create([
                'name'     => $validated['customer_name'],
                'mobile'   => $validated['customer_mobile'],
                'password' => Hash::make(Str::random(40)),
                'type'     => 'customer',
                'status'   => 'approved',
            ]);

            $created = ! $existing;

            /*
            | نام مشتری موجود را بازنویسی نمی‌کنیم — خودش ثبتش کرده و
            | ادمین ممکن است اسم را ناقص شنیده باشد.
            */
            $customer = Customer::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'name'     => $validated['customer_name'],
                    'mobile'   => $validated['customer_mobile'],
                    'phone'    => $validated['customer_phone'] ?? null,
                    'province' => $validated['province'] ?? null,
                    'city'     => $validated['city'] ?? null,
                    'address'  => $validated['address'],
                ],
            );

            return [$customer, $created];

        });


        $building = DB::transaction(function () use ($customer, $validated) {

            $building = Building::create([
                'customer_id'    => $customer->id,
                'title'          => $validated['title'],
                'province'       => $validated['province'] ?? null,
                'city'           => $validated['city'] ?? null,
                'address'        => $validated['address'],
                'postal_code'    => $validated['postal_code'] ?? null,
                'floors'         => $validated['floors'] ?? null,
                'units'          => $validated['units'] ?? null,
                'manager_name'   => $validated['manager_name'] ?? null,
                'manager_mobile' => $validated['manager_mobile'] ?? null,
                'notes'          => $validated['notes'] ?? null,
            ]);

            // همان قاعده‌ی سمت مشتری: پرونده بدون دستگاه بی‌معناست.
            $elevators = collect($validated['elevators'] ?? [])
                ->filter(fn ($e) => filled($e['label'] ?? null));

            if ($elevators->isEmpty()) {
                $elevators = collect([['label' => 'آسانسور ۱']]);
            }

            foreach ($elevators as $elevator) {
                $building->elevators()->create([
                    'label'        => $elevator['label'],
                    'brand'        => $elevator['brand'] ?? null,
                    'capacity_kg'  => $elevator['capacity_kg'] ?? null,
                    'stops'        => $elevator['stops'] ?? null,
                    'install_year' => $elevator['install_year'] ?? null,
                    'serial_no'    => $elevator['serial_no'] ?? null,
                ]);
            }

            return $building;

        });


        $note = $accountCreated
            ? 'حساب مشتری با شماره ' . $customer->mobile . ' ساخته شد؛ می‌تواند با کد پیامکی وارد شود.'
            : 'پرونده به حساب مشتری موجود اضافه شد.';

        return redirect()
            ->route('admin.buildings.show', $building)
            ->with('success', 'پرونده‌ی ' . $building->code . ' ساخته شد. ' . $note);
    }


    public function show(Building $building)
    {
        $building->load([
            'customer',
            'elevators',
            'contracts.technician',
            'serviceRequests.technician',
        ]);

        return view('admin.buildings.show', [
            'building'       => $building,
            'activeContract' => $building->activeContract,
        ]);
    }


    /**
     * فرم قرارداد. قیمت هر ترکیب طرح/دوره از همان config سمت مشتری
     * می‌آید تا عددی که ادمین به مشتری می‌گوید با سایت یکی باشد.
     */
    public function contractCreate(Building $building)
    {
        if ($building->activeContract) {

            return redirect()
                ->route('admin.buildings.show', $building)
                ->with('error', 'این پرونده قرارداد فعال دارد.');

        }

        $elevatorCount = max(1, $building->elevators()->count());

        $quotes = [];

        foreach (array_keys(config('proservice.plans')) as $plan) {
            foreach (array_keys(config('proservice.terms')) as $term) {

                $draft = new ServiceContract(['plan' => $plan, 'term' => $term]);

                $quotes[$plan][$term] = $draft
                    ->priceFromConfig($elevatorCount)
                    ->total_amount;

            }
        }

        return view('admin.buildings.contract', [
            'building'      => $building->load('customer'),
            'elevatorCount' => $elevatorCount,
            'plans'         => config('proservice.plans'),
            'terms'         => config('proservice.terms'),
            'modes'         => config('proservice.technician_modes'),
            'quotes'        => $quotes,
            'technicians'   => $this->technicianOptions($building),
        ]);
    }


    /**
     * قرارداد را در همان وضعیت pending_review می‌سازد که مشتری می‌ساخت،
     * تا ادمین از صفحه‌ی قراردادها قیمت نهایی را بگذارد و مشتری پرداخت
     * کند. عمداً اینجا قیمت‌گذاری نمی‌کنیم تا یک مسیر پول بیشتر نداشته
     * باشیم.
     */
    public function contractStore(Request $request, Building $building)
    {
        abort_if((bool) $building->activeContract, 409, 'این پرونده قرارداد فعال دارد.');

        $validated = $request->validate([
            'plan'            => 'required|in:' . implode(',', array_keys(config('proservice.plans'))),
            'term'            => 'required|in:' . implode(',', array_keys(config('proservice.terms'))),
            'technician_mode' => 'required|in:' . implode(',', array_keys(config('proservice.technician_modes'))),
            'technician_id'   => 'nullable|exists:technicians,id|required_if:technician_mode,dedicated',
        ], [], [
            'plan'            => 'طرح',
            'term'            => 'دوره',
            'technician_mode' => 'نحوه‌ی تعیین تکنسین',
            'technician_id'   => 'تکنسین',
        ]);

        $contract = $this->contracts->request(
            $building,
            $validated['plan'],
            $validated['term'],
            $validated['technician_mode'],
            $validated['technician_id'] ?? null,
        );

        return redirect()
            ->route('admin.contracts.show', $contract)
            ->with('success', 'قرارداد ' . $contract->code . ' ثبت شد. حالا قیمت نهایی را بگذارید تا برای پرداخت به مشتری برود.');
    }


    /**
     * تکنسین‌های قابل انتخاب، مرتب بر اساس امتیاز. هم‌شهری‌ها اول
     * می‌آیند چون سرویس آسانسور کار حضوری است.
     */
    private function technicianOptions(Building $building)
    {
        return Technician::query()
            ->where('is_active', true)
            ->where('is_verified', true)
            ->orderByRaw('CASE WHEN city = ? THEN 0 ELSE 1 END', [$building->city])
            ->orderByDesc('rating')
            ->orderByDesc('reviews_count')
            ->limit(50)
            ->get();
    }
}
