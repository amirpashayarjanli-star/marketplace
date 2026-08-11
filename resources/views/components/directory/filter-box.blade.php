<div class="directory-filter glass-card">

    <form method="GET" class="w-full space-y-3">

        {{-- Search --}}
        <div class="directory-search">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input
                type="text"
                name="search"
                placeholder="جستجوی شرکت آسانسوری..."
                value="{{ request('search') }}">
        </div>

        {{-- Filters --}}
        <div class="directory-options">

            <select name="city" onchange="this.form.submit()">
                <option value="">انتخاب شهر</option>
                <option value="تهران" {{ request('city') === 'تهران' ? 'selected' : '' }}>تهران</option>
                <option value="قم" {{ request('city') === 'قم' ? 'selected' : '' }}>قم</option>
                <option value="اصفهان" {{ request('city') === 'اصفهان' ? 'selected' : '' }}>اصفهان</option>
                <option value="مشهد" {{ request('city') === 'مشهد' ? 'selected' : '' }}>مشهد</option>
                <option value="کرج" {{ request('city') === 'کرج' ? 'selected' : '' }}>کرج</option>
                <option value="تبریز" {{ request('city') === 'تبریز' ? 'selected' : '' }}>تبریز</option>
                <option value="شیراز" {{ request('city') === 'شیراز' ? 'selected' : '' }}>شیراز</option>
                <option value="کیش" {{ request('city') === 'کیش' ? 'selected' : '' }}>کیش</option>
                <option value="آنجا" {{ request('city') === 'آنجا' ? 'selected' : '' }}>آنجا</option>
            </select>

            <select name="sort" onchange="this.form.submit()">
                <option value="">مرتب سازی</option>
                <option value="rating" {{ request('sort') === 'rating' ? 'selected' : '' }}>بیشترین امتیاز</option>
                <option value="reviews" {{ request('sort') === 'reviews' ? 'selected' : '' }}>بیشترین نظر</option>
                <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>جدیدترین</option>
            </select>
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            <i class="fa-solid fa-search ml-2"></i>جستجو
        </button>

    </form>

    {{-- Register Company --}}
    <a href="{{ route('register') }}"
       class="register-company-btn block text-center mt-3">
        <i class="fa-solid fa-building"></i>
        {{ $register ?? 'ثبت' }}
    </a>

</div>
