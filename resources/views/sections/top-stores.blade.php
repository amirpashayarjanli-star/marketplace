<section class="section top-stores">

    <div class="container">

        <x-section-title
            title="برترین فروشگاه‌ها"
            link="{{ route('stores.index') }}"
            linkText="مشاهده همه"
        />

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            @foreach($topStores as $store)

                <a href="{{ route('store.profile', $store->slug) }}"
                   class="block">

                    <x-card-store :store="$store" />

                </a>

            @endforeach

        </div>

    </div>

</section>
