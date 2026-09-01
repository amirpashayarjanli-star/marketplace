<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Bid;
use App\Services\AuctionService;
use App\Exceptions\InsufficientWalletBalanceException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


/*
|--------------------------------------------------------------------------
| پرو مزایده — سمت پیشنهاددهنده (شرکت / تولیدکننده / تکنسین)
|--------------------------------------------------------------------------
*/

class BidController extends Controller
{

    public function __construct(
        protected AuctionService $auctions,
    ) {}




    public function index()
    {

        $bids = Bid::query()
            ->where('user_id', Auth::id())
            ->with('auction')
            ->latest()
            ->get();

        return view('dashboard.bids.index', compact('bids'));
    }




    public function store(Request $request, Auction $auction)
    {

        $data = $request->validate([
            'amount'        => 'required|integer|min:1',
            'delivery_days' => 'nullable|integer|min:1|max:3650',
            'description'   => 'nullable|string|max:2000',
        ]);

        try {

            $this->auctions->placeBid($auction, Auth::user(), $data);

        } catch (InsufficientWalletBalanceException $e) {

            return redirect()
                ->route('wallet')
                ->with('error', 'برای ثبت پیشنهاد باید کارمزد ۵٪ از کیف‌پول کسر شود؛ موجودی کافی نیست.');
        }

        return redirect()
            ->route('auction.show', $auction->slug)
            ->with('success', 'پیشنهاد شما ثبت شد و کارمزد از کیف‌پول کسر گردید.');
    }




    public function update(Request $request, Bid $bid)
    {

        $this->authorizeOwner($bid);

        $data = $request->validate([
            'amount'        => 'required|integer|min:1',
            'delivery_days' => 'nullable|integer|min:1|max:3650',
            'description'   => 'nullable|string|max:2000',
        ]);

        $this->auctions->updateBid($bid, $data);

        return redirect()
            ->route('auction.show', $bid->auction->slug)
            ->with('success', 'پیشنهاد شما به‌روزرسانی شد.');
    }




    public function withdraw(Bid $bid)
    {

        $this->authorizeOwner($bid);

        $slug = $bid->auction->slug;

        $this->auctions->withdrawBid($bid);

        return redirect()
            ->route('auction.show', $slug)
            ->with('success', 'از پیشنهاد انصراف دادید و کارمزد به کیف‌پول برگشت.');
    }




    private function authorizeOwner(Bid $bid): void
    {
        abort_unless($bid->user_id === Auth::id(), 403, 'دسترسی رد شد.');
    }
}
