<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Company;
use App\Models\HeroSlide;
use App\Models\Manufacturer;
use App\Models\Project;
use App\Models\Store;
use App\Models\Technician;
use App\Services\MarketRatesService;

class HomeController extends Controller
{
    public function index(MarketRatesService $rates)
    {
        $topCompanies = Company::where('is_active', 1)->latest()->limit(6)->get();
        $topManufacturers = Manufacturer::where('is_active', 1)->latest()->limit(6)->get();
        $topStores = Store::where('is_active', 1)->latest()->limit(6)->get();
        $topTechnicians = Technician::where('is_active', 1)->latest()->limit(6)->get();
        $latestProjects = Project::where('is_active', 1)->latest()->limit(6)->get();

        /*
         | مناقصه‌های در حال برگزاری برای سکشن پرو مزایده.
         | leading_amount = کمترین پیشنهاد فعال، همان «پیشرو» که در کارت
         | نشان داده می‌شود.
         */
        $latestAuctions = Auction::active()
            ->withCount(['bids' => fn ($q) => $q->where('status', 'active')])
            ->withMin(['bids as leading_amount' => fn ($q) => $q->where('status', 'active')], 'amount')
            ->orderByDesc('created_at')
            ->limit(3)
            ->get();

        $latestInquiries = collect([]);
        $latestArticles = collect([]);

        // اسلایدهای هیرو — کاملاً از پنل مدیریت کنترل میشن
        $heroSlides = HeroSlide::visible()->get();

        // نرخ‌های لحظه‌ای (دلار / طلا / سکه)
        $marketRates = $rates->all();

        /*
         | آمار نوار اعتماد.
         | فقط موارد تاییدشده شمرده میشن — یعنی همون‌هایی که واقعاً
         | در فهرست‌های سایت دیده میشن. اگر منتظرهای تایید رو هم
         | می‌شمردیم، عدد با چیزی که کاربر بعد از کلیک می‌بینه جور
         | درنمیومد.
         */
        $stats = [
            'companies'     => Company::where('is_active', 1)->count(),
            'manufacturers' => Manufacturer::where('is_active', 1)->count(),
            'stores'        => Store::where('is_active', 1)->count(),
            'technicians'   => Technician::where('is_active', 1)->count(),
            'projects'      => Project::where('is_active', 1)->count(),
        ];

        return view('pages.home', compact(
            'topCompanies',
            'topManufacturers',
            'topStores',
            'topTechnicians',
            'latestProjects',
            'latestAuctions',
            'latestInquiries',
            'latestArticles',
            'heroSlides',
            'marketRates',
            'stats'
        ));
    }
}
