<section class="section top-technicians">

    <div class="container">

        <x-section-title
            title="برترین تکنسین‌ها"
            link="{{ route('technicians.index') }}"
            linkText="مشاهده همه"
        />

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            @foreach($topTechnicians as $technician)

                <a href="{{ route('technician.profile', $technician->slug) }}"
                   class="block">

                    <x-card-technician :technician="$technician" />

                </a>

            @endforeach

        </div>

    </div>

</section>
