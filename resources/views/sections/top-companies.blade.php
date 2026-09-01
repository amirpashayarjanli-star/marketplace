<section class="section top-companies">

    <div class="container-app">

        <x-section-title
            title="برترین شرکت‌های آسانسوری"
            url="{{ route('companies.index') }}"
            button="مشاهده همه"
        />


        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            @forelse($topCompanies ?? [] as $company)

                <a href="{{ route('company.profile', $company->slug) }}"
                   class="block">

                    <x-card-company :company="$company" />

                </a>

            @empty

                <div class="col-span-full text-center py-8">
                    هنوز شرکتی ثبت نشده است.
                </div>

            @endforelse

        </div>

    </div>

</section>
