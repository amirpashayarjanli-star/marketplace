<section class="section top-companies">

    <div class="container">

        <x-section-title
            title="برترین شرکت‌های آسانسوری"
            link="{{ route('companies.index') }}"
            linkText="مشاهده همه"
        />

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            @foreach($topCompanies as $company)

                <a href="{{ route('company.profile', $company->slug) }}"
                   class="block">

                    <x-card-company :company="$company" />

                </a>

            @endforeach

        </div>

    </div>

</section>
