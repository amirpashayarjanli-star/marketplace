<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Company;
use App\Models\Manufacturer;
use App\Models\Project;
use App\Models\Store;
use App\Models\Technician;
use Illuminate\Http\Response;

/*
|--------------------------------------------------------------------------
| sitemap.xml
|--------------------------------------------------------------------------
|
| دامنه قبلاً یک فروشگاه وردپرسی بود و صفحه‌های آن هنوز در ایندکس گوگل
| مانده‌اند. با معرفی نقشه‌ی سایتِ واقعی، گوگل صفحه‌های درست را می‌بیند و
| نشانی‌های قدیمی را زودتر کنار می‌گذارد.
|
*/

class SitemapController extends Controller
{

    public function index(): Response
    {

        $urls = [];

        // صفحه‌های ثابت
        foreach ([
            ['/', '1.0', 'daily'],
            ['/companies', '0.8', 'daily'],
            ['/manufacturers', '0.8', 'daily'],
            ['/stores', '0.8', 'daily'],
            ['/technicians', '0.8', 'daily'],
            ['/projects', '0.8', 'daily'],
            ['/auctions', '0.9', 'hourly'],
            ['/register', '0.5', 'monthly'],
            ['/login', '0.3', 'monthly'],
        ] as [$path, $priority, $freq]) {
            $urls[] = [
                'loc'      => url($path),
                'priority' => $priority,
                'freq'     => $freq,
            ];
        }

        // پروفایل‌ها و پروژه‌ها و مزایده‌ها
        $sets = [
            [Company::class,      'company',      ['is_active' => 1]],
            [Manufacturer::class, 'manufacturer', ['is_active' => 1]],
            [Store::class,        'store',        ['is_active' => 1]],
            [Technician::class,   'technician',   ['is_active' => 1]],
            [Project::class,      'project',      ['is_active' => 1]],
        ];

        foreach ($sets as [$model, $prefix, $where]) {
            $model::query()
                ->where($where)
                ->whereNotNull('slug')
                ->select('slug', 'updated_at')
                ->orderByDesc('updated_at')
                ->limit(2000)
                ->get()
                ->each(function ($row) use (&$urls, $prefix) {
                    $urls[] = [
                        'loc'      => url("/{$prefix}/{$row->slug}"),
                        'lastmod'  => optional($row->updated_at)->toAtomString(),
                        'priority' => '0.7',
                        'freq'     => 'weekly',
                    ];
                });
        }

        // مزایده‌های عمومی
        Auction::query()
            ->public()
            ->select('slug', 'updated_at')
            ->orderByDesc('updated_at')
            ->limit(2000)
            ->get()
            ->each(function ($row) use (&$urls) {
                $urls[] = [
                    'loc'      => url("/auction/{$row->slug}"),
                    'lastmod'  => optional($row->updated_at)->toAtomString(),
                    'priority' => '0.8',
                    'freq'     => 'daily',
                ];
            });

        $xml  = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($urls as $u) {
            $xml .= "  <url>\n";
            $xml .= '    <loc>' . htmlspecialchars($u['loc'], ENT_XML1) . "</loc>\n";
            if (! empty($u['lastmod'])) {
                $xml .= '    <lastmod>' . $u['lastmod'] . "</lastmod>\n";
            }
            $xml .= '    <changefreq>' . $u['freq'] . "</changefreq>\n";
            $xml .= '    <priority>' . $u['priority'] . "</priority>\n";
            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>';

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
        ]);
    }
}
