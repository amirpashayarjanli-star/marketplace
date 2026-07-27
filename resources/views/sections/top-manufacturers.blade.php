<section class="section top-manufacturers">

    <div class="container">

        <x-section-title
            title="برترین تولیدکنندگان"
            link="{{ route('manufacturers.index') }}"
            linkText="مشاهده همه"
        />

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            @foreach($topManufacturers as $manufacturer)

                <a href="{{ route('manufacturer.profile', $manufacturer->slug) }}"
                   class="block">

                    <x-card-manufacturer :manufacturer="$manufacturer" />

                </a>

            @endforeach

        </div>

    </div>

</section>
