<section class="latest-inquiries">

    <div class="container">

        <x-section-title
            title="آخرین استعلام‌ها"
            description="جدیدترین درخواست‌های ثبت شده در آسانسور پرو"
        />

        <div class="latest-projects-grid">

            @forelse($latestInquiries as $inquiry)

                @include('components.card-inquiry')

            @empty

                <div class="slider-empty">

                    <i class="fa-regular fa-folder-open"></i>

                    <h3>هنوز استعلامی ثبت نشده است.</h3>

                </div>

            @endforelse

        </div>

    </div>

</section>