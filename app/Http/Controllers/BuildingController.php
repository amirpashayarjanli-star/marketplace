<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * پرونده‌های ساختمان مشتری — فهرست، ساخت، ویرایش و نمای پرونده.
 */
class BuildingController extends Controller
{
    private function customerOrRedirect(): Customer
    {
        $customer = Customer::where('user_id', auth()->id())->first();

        abort_if(! $customer, 403, 'برای استفاده از پروسرویس ابتدا پروفایل مشتری را کامل کنید.');

        return $customer;
    }


    private function ownedBuilding(Building $building): Building
    {
        abort_if($building->customer_id !== $this->customerOrRedirect()->id, 403);

        return $building;
    }


    public function index()
    {
        $customer = $this->customerOrRedirect();

        $buildings = $customer->buildings()
            ->withCount(['elevators', 'serviceRequests'])
            ->with('activeContract')
            ->get();

        return view('service.buildings.index', [
            'customer'  => $customer,
            'buildings' => $buildings,
        ]);
    }


    public function create()
    {
        return view('service.buildings.create', [
            'customer'  => $this->customerOrRedirect(),
            'provinces' => config('provinces', []),
        ]);
    }


    public function store(Request $request)
    {
        $customer = $this->customerOrRedirect();

        $validated = $this->validated($request);

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

            /*
            | پرونده بدون دستگاه بی‌معناست — قیمت قرارداد به تعداد
            | دستگاه بستگی دارد. اگر مشتری چیزی وارد نکرده باشد،
            | یک دستگاه پیش‌فرض ساخته می‌شود که بعداً ویرایش کند.
            */
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

        return redirect()
            ->route('service.buildings.show', $building)
            ->with('success', 'پرونده‌ی «' . $building->title . '» ساخته شد. حالا می‌توانید قرارداد سرویس ببندید.');
    }


    public function show(Building $building)
    {
        $this->ownedBuilding($building);

        $building->load([
            'elevators',
            'contracts.technician',
            'contracts.activePolicy',
            'serviceRequests.technician',
        ]);

        return view('service.buildings.show', [
            'building'       => $building,
            'activeContract' => $building->activeContract,
        ]);
    }


    public function edit(Building $building)
    {
        $this->ownedBuilding($building);

        return view('service.buildings.edit', [
            'building'  => $building->load('elevators'),
            'provinces' => config('provinces', []),
        ]);
    }


    public function update(Request $request, Building $building)
    {
        $this->ownedBuilding($building);

        $validated = $this->validated($request);

        $building->update([
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

        return redirect()
            ->route('service.buildings.show', $building)
            ->with('success', 'پرونده به‌روزرسانی شد.');
    }


    /**
     * افزودن یک دستگاه به پرونده. تعداد دستگاه روی قیمت قرارداد اثر
     * دارد، پس قراردادهای فعال دست‌نخورده می‌مانند و تغییر از تمدید
     * بعدی اعمال می‌شود.
     */
    public function storeElevator(Request $request, Building $building)
    {
        $this->ownedBuilding($building);

        $validated = $request->validate([
            'label'        => 'required|string|max:120',
            'brand'        => 'nullable|string|max:120',
            'capacity_kg'  => 'nullable|integer|min:0|max:10000',
            'stops'        => 'nullable|integer|min:0|max:200',
            'install_year' => 'nullable|integer|min:1300|max:1500',
            'serial_no'    => 'nullable|string|max:120',
        ], [], [
            'label'        => 'نام دستگاه',
            'brand'        => 'برند',
            'capacity_kg'  => 'ظرفیت',
            'stops'        => 'تعداد توقف',
            'install_year' => 'سال نصب',
            'serial_no'    => 'شماره سریال',
        ]);

        $building->elevators()->create($validated);

        return back()->with('success', 'دستگاه به پرونده اضافه شد.');
    }


    public function destroyElevator(Building $building, int $elevator)
    {
        $this->ownedBuilding($building);

        if ($building->elevators()->count() <= 1) {
            return back()->with('error', 'هر پرونده باید حداقل یک دستگاه داشته باشد.');
        }

        $building->elevators()->whereKey($elevator)->delete();

        return back()->with('success', 'دستگاه حذف شد.');
    }


    private function validated(Request $request): array
    {
        return $request->validate([

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
            'title'          => 'نام ساختمان',
            'province'       => 'استان',
            'city'           => 'شهر',
            'address'        => 'آدرس',
            'postal_code'    => 'کد پستی',
            'floors'         => 'تعداد طبقات',
            'units'          => 'تعداد واحدها',
            'manager_name'   => 'نام مدیر ساختمان',
            'manager_mobile' => 'موبایل مدیر ساختمان',
            'notes'          => 'توضیحات',
        ]);
    }
}
