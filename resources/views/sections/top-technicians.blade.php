<section class="section top-technicians">

    <div class="container-app">

        <x-section-title
            title="برترین تکنسین‌ها"
            url="{{ route('technicians.index') }}"
            button="مشاهده همه"
        />


        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            @forelse($topTechnicians ?? [] as $technician)

                <a href="{{ route('technician.profile', $technician->slug) }}"
                   class="block">

                    <x-card-technician :technician="$technician" />

                </a>

            @empty

                <div class="col-span-full text-center py-8">
                    هنوز تکنسینی ثبت نشده است.
                </div>

            @endforelse

        </div>

    </div>

</section>
