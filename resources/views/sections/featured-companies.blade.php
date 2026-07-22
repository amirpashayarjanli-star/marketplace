<div class="swiper companies-swiper">

    <div class="swiper-wrapper">

        @forelse($companies as $company)

            <div class="swiper-slide">

                <a href="{{ route('companies.show', $company->slug) }}" class="company-card">

                    <div class="company-cover">

                        <img
                            src="{{ $company->cover ? asset('storage/'.$company->cover) : asset('images/default/company-cover.webp') }}"
                            alt="{{ $company->name }}"
                        >

                        @if($company->verified)
                            <span class="company-badge">
                                ✔ تایید شده
                            </span>
                        @endif

                    </div>

                    <div class="company-body">

                        <div class="company-logo">

                            <img
                                src="{{ $company->logo ? asset('storage/'.$company->logo) : asset('images/default/company-logo.webp') }}"
                                alt="{{ $company->name }}"
                            >

                        </div>

                        <h3 class="company-name">
                            {{ $company->name }}
                        </h3>

                        <p class="company-category">
                            {{ $company->category->title ?? 'شرکت آسانسوری' }}
                        </p>

                        <div class="company-location">

                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                                <path d="M12 22C12 22 19 15.5 19 10.5C19 6.35786 15.866 3 12 3C8.13401 3 5 6.35786 5 10.5C5 15.5 12 22 12 22Z"
                                    stroke="currentColor"
                                    stroke-width="1.8"/>

                                <circle
                                    cx="12"
                                    cy="10"
                                    r="2.5"
                                    stroke="currentColor"
                                    stroke-width="1.8"/>
                            </svg>

                            <span>
                                {{ $company->city }}
                                @if($company->province)
                                    ، {{ $company->province }}
                                @endif
                            </span>

                        </div>

                        <div class="company-stats">

                            <div>
                                <strong>{{ $company->projects_count ?? 0 }}</strong>
                                <span>پروژه</span>
                            </div>

                            <div>
                                <strong>{{ $company->products_count ?? 0 }}</strong>
                                <span>محصول</span>
                            </div>

                            <div>
                                <strong>{{ number_format($company->rating ?? 5,1) }}</strong>
                                <span>⭐ امتیاز</span>
                            </div>

                        </div>

                        <div class="company-footer">

                            <span class="members">
                                {{ number_format($company->followers_count ?? 0) }}
                                دنبال‌کننده
                            </span>

                            <span class="view-profile">

                                مشاهده پروفایل

                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                                    <path d="M9 6L15 12L9 18"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"/>
                                </svg>

                            </span>

                        </div>

                    </div>

                </a>

            </div>

        @empty

            <div class="swiper-slide">

                <div class="empty-slider">

                    <h3>هنوز هیچ شرکتی ثبت نشده است.</h3>

                    <p>به‌زودی اولین شرکت در این بخش نمایش داده می‌شود.</p>

                </div>

            </div>

        @endforelse

    </div>

    <div class="swiper-pagination"></div>

</div>