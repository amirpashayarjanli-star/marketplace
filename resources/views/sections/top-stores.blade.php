<section class="section top-stores">

    <div class="container">

        <x-section-title
            title="برترین فروشگاه‌ها"
            url="{{ route('stores.index') }}"
            button="مشاهده همه"
        />


        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            @forelse($topStores ?? [] as $store)

                <a href="{{ route('store.profile', $store->slug) }}"
                   class="block">

                    <x-card-store :store="$store" />

                </a>

            @empty

                <div class="col-span-full text-center py-8">
                    هنوز فروشگاهی ثبت نشده است.
                </div>

            @endforelse

        </div>

    </div>

</section>
