<section class="section top-manufacturers">

    <div class="container-app">

        <x-section-title
            title="برترین تولیدکنندگان"
            url="{{ route('manufacturers.index') }}"
            button="مشاهده همه"
        />


        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            @forelse($topManufacturers ?? [] as $manufacturer)

                <a href="{{ route('manufacturer.profile', $manufacturer->slug) }}"
                   class="block">

                    <x-card-manufacturer :manufacturer="$manufacturer" />

                </a>

            @empty

                <div class="col-span-full text-center py-8">
                    هنوز تولیدکننده‌ای ثبت نشده است.
                </div>

            @endforelse

        </div>

    </div>

</section>
