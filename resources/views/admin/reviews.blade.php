@extends('layouts.app')

@section('title', 'تایید نظرات')

@section('content')

<div class="wizard-page">

    <div class="wizard-shell" style="max-width:960px">


        @include('admin.partials.nav')


        <div class="service-page-head">
            <div>
                <h1 class="wizard-title">نظرات منتظر تایید</h1>
                <p class="wizard-subtitle">تا تایید نکنید، در پروفایل‌ها نمایش داده نمی‌شوند.</p>
            </div>
        </div>


        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif


        <div class="service-list">

            @forelse($reviews as $review)

                <div class="card review-moderation">

                    <div class="review-moderation-head">

                        <div>
                            <h3>{{ $review->name }}</h3>
                            <p class="building-card-meta">
                                {{ $review->reviewable?->name ?? '(حذف شده)' }}
                                · {{ jdate($review->created_at) }}
                            </p>
                        </div>

                        <div class="review-moderation-stars">
                            @for($i = 1; $i <= 5; $i++)
                                <x-ui.icon name="star"
                                    style="color: {{ $i <= $review->rating ? 'var(--gold)' : 'var(--border-strong)' }}" />
                            @endfor
                        </div>

                    </div>

                    <p class="review-moderation-comment">{{ $review->comment }}</p>

                    <div class="review-moderation-actions">

                        <form method="POST" action="{{ route('admin.reviews.approve', $review) }}">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success">
                                <x-ui.icon name="check" />تایید
                            </button>
                        </form>

                        <form method="POST" action="{{ route('admin.reviews.reject', $review) }}"
                              onsubmit="return confirm('این نظر حذف شود؟')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger-outline">
                                <x-ui.icon name="trash" />حذف
                            </button>
                        </form>

                    </div>

                </div>

            @empty

                <p class="auction-blocked">هیچ نظر منتظر تاییدی وجود ندارد.</p>

            @endforelse

        </div>


    </div>

</div>

@endsection
