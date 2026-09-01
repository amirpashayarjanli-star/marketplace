<section class="latest-inquiries">

    <div class="container-app">

        <x-section-title
            title="آخرین استعلام‌ها"
            description="جدیدترین درخواست‌های ثبت شده در آسانسور پرو"
        />

        <div class="latest-projects-grid">

            @forelse($latestInquiries as $inquiry)

                @include('components.header.card-inquiry', ['inquiry' => $inquiry])

            @empty

                <div class="slider-empty">

                    <x-ui.icon name="folder-open" />

                    <h3>هنوز استعلامی ثبت نشده است.</h3>

                </div>

            @endforelse

        </div>

    </div>

</section>