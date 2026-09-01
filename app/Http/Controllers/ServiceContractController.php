<?php

namespace App\Http\Controllers;

use App\Exceptions\InsufficientWalletBalanceException;
use App\Models\Building;
use App\Models\Customer;
use App\Models\ServiceContract;
use App\Models\Technician;
use App\Models\Wallet;
use App\Services\ServiceContractService;
use App\Services\ServiceNotifier;
use Illuminate\Http\Request;

/**
 * قرارداد سرویس از دید مشتری — انتخاب طرح، پرداخت، مشاهده و لغو.
 */
class ServiceContractController extends Controller
{
    public function __construct(
        private ServiceContractService $contracts,
        private ServiceNotifier $notifier,
    ) {
    }


    private function customerOrAbort(): Customer
    {
        $customer = Customer::where('user_id', auth()->id())->first();

        abort_if(! $customer, 403, 'برای استفاده از پروسرویس ابتدا پروفایل مشتری را کامل کنید.');

        return $customer;
    }


    private function ownedBuilding(Building $building): Building
    {
        abort_if($building->customer_id !== $this->customerOrAbort()->id, 403);

        return $building;
    }


    private function ownedContract(ServiceContract $contract): ServiceContract
    {
        $this->ownedBuilding($contract->building);

        return $contract;
    }


    /**
     * فرم انتخاب طرح. قیمت هر ترکیب طرح/دوره همین‌جا حساب می‌شود تا
     * مشتری قبل از ثبت، عدد نهایی را ببیند.
     */
    public function create(Building $building)
    {
        $this->ownedBuilding($building);

        if ($building->activeContract) {
            return redirect()
                ->route('service.buildings.show', $building)
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

        return view('service.contracts.create', [
            'building'      => $building,
            'elevatorCount' => $elevatorCount,
            'plans'         => config('proservice.plans'),
            'terms'         => config('proservice.terms'),
            'modes'         => config('proservice.technician_modes'),
            'quotes'        => $quotes,
            'technicians'   => $this->technicianOptions($building),
        ]);
    }


    public function store(Request $request, Building $building)
    {
        $this->ownedBuilding($building);

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
            ->route('service.contracts.show', $contract)
            ->with('success', 'درخواست قرارداد ثبت شد. کارشناسان ما بررسی و قیمت نهایی را اعلام می‌کنند.');
    }


    public function show(ServiceContract $contract)
    {
        $this->ownedContract($contract);

        $contract->load(['building.elevators', 'technician', 'visits.technician', 'policies']);

        return view('service.contracts.show', [
            'contract' => $contract,
            'balance'  => Wallet::forUser(auth()->user())->balance,
        ]);
    }


    /**
     * پرداخت از کیف‌پول و فعال‌سازی قرارداد.
     */
    public function pay(ServiceContract $contract)
    {
        $this->ownedContract($contract);

        if ($contract->status !== 'awaiting_payment') {
            return back()->with('error', 'این قرارداد در مرحله‌ی پرداخت نیست.');
        }

        try {
            $this->contracts->activateFromWallet($contract);
        } catch (InsufficientWalletBalanceException $e) {
            return back()->with(
                'error',
                'موجودی کیف‌پول کافی نیست. مبلغ لازم: ' . number_format($contract->total_amount) . ' تومان.'
            );
        }

        $this->notifier->contractActivated($contract->fresh('building.customer'));

        return redirect()
            ->route('service.contracts.show', $contract)
            ->with('success', 'قرارداد فعال شد.');
    }


    public function cancel(Request $request, ServiceContract $contract)
    {
        $this->ownedContract($contract);

        if (in_array($contract->status, ['cancelled', 'expired'], true)) {
            return back()->with('error', 'این قرارداد قبلاً بسته شده است.');
        }

        $validated = $request->validate([
            'reason' => 'nullable|string|max:300',
        ], [], ['reason' => 'دلیل']);

        $this->contracts->cancel($contract, $validated['reason'] ?? null);

        return back()->with('success', 'قرارداد لغو شد. برای تسویه‌ی باقی‌مانده‌ی دوره با پشتیبانی تماس بگیرید.');
    }


    /**
     * تکنسین‌های قابل انتخاب برای این پرونده، مرتب بر اساس امتیاز.
     * هم‌شهری‌ها اول می‌آیند چون سرویس آسانسور کار حضوری است.
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
