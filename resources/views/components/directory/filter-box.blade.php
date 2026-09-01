@php
    $provinces = config('provinces', []);
@endphp

<div class="directory-filter glass-card">

    <form method="GET" class="directory-filter-form">

        {{-- Search --}}
        <div class="directory-search">

            <button type="submit" class="directory-search-btn" aria-label="جستجو">
                <x-ui.icon name="magnifying-glass" />
            </button>

            <input
                type="text"
                name="search"
                placeholder="{{ $search ?? 'جستجو...' }}"
                class="input"
                value="{{ request('search') }}">

        </div>

        {{-- Filters --}}
        <div class="directory-options">

            <div class="directory-province">

                <input
                    type="text"
                    name="province"
                    list="province-options"
                    class="input"
                    autocomplete="off"
                    placeholder="جستجوی استان..."
                    value="{{ request('province') }}">

                <datalist id="province-options">
                    @foreach($provinces as $province)
                        <option value="{{ $province }}">
                    @endforeach
                </datalist>

            </div>

            <select name="sort" onchange="this.form.submit()">
                <option value="">مرتب سازی</option>
                <option value="rating" {{ request('sort') === 'rating' ? 'selected' : '' }}>بیشترین امتیاز</option>
                <option value="reviews" {{ request('sort') === 'reviews' ? 'selected' : '' }}>بیشترین نظر</option>
                <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>جدیدترین</option>
            </select>

        </div>

    </form>

    {{-- Register Company --}}
    <a href="{{ route('register') }}"
       class="register-company-btn">
        <x-ui.icon name="building" />
        {{ $register ?? 'ثبت' }}
    </a>

</div>
