<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


/*
|--------------------------------------------------------------------------
| پرو مزایده — نمای عمومی
|--------------------------------------------------------------------------
*/

class AuctionController extends Controller
{

    public function index(Request $request)
    {

        $auctions = Auction::query()
            ->public()
            ->with(['employer', 'winnerBid'])
            ->withCount(['bids' => fn ($q) => $q->where('status', 'active')])
            ->withMin(['bids as leading_amount' => fn ($q) => $q->where('status', 'active')], 'amount')
            ->when($request->filled('scope'), fn ($q) => $q->where('scope', $request->scope))
            ->when($request->filled('province'), fn ($q) => $q->where('province', $request->province))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->when($request->filled('source'), fn ($q) => $q->where('source', $request->source))
            // مرتب‌سازی «در حال برگزاری اول» — با CASE نه FIELD چون FIELD فقط
            // در MySQL هست و روی SQLite (محیط توسعه) کل صفحه ۵۰۰ می‌شد.
            ->orderByRaw("CASE status WHEN 'active' THEN 1 WHEN 'closed' THEN 2 ELSE 3 END")
            ->orderByDesc('ends_at')
            ->paginate(12)
            ->withQueryString();

        return view('auctions.index', [
            'auctions' => $auctions,
            'scopes'   => Auction::SCOPES,
            'sources'  => Auction::SOURCES,
        ]);
    }




    public function show(string $slug)
    {

        $auction = Auction::query()
            ->public()
            ->where('slug', $slug)
            ->with([
                'employer',
                'project',
                'bids' => fn ($q) => $q->orderBy('amount')->orderBy('created_at'),
                'bids.user.company',
                'bids.user.manufacturer',
                'bids.user.technician',
            ])
            ->firstOrFail();

        $user = Auth::user();

        $myBid = $user
            ? $auction->bids->firstWhere('user_id', $user->id)
            : null;

        $canBid = $user
            && $auction->isOpen()
            && $auction->bids_enabled
            && in_array($user->type, $auction->allowedBidderTypes(), true)
            && $user->status === 'approved'
            && $auction->employer?->user_id !== $user->id;

        return view('auctions.show', [
            'auction' => $auction,
            'myBid'   => $myBid,
            'canBid'  => $canBid,
        ]);
    }
}
