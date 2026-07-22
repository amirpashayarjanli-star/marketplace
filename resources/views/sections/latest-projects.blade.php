<section class="latest-projects">

    <div class="container">

        <x-section-title
            title="آخرین پروژه‌های ثبت شده"
            description="جدیدترین پروژه‌های ثبت شده در آسانسور پرو"
        />

        <div class="latest-projects-grid">

            @forelse($latestProjects as $project)

                @include('components.card-project')

            @empty

                <div class="slider-empty">

                    <i class="fa-regular fa-folder-open"></i>

                    <h3>هنوز پروژه‌ای ثبت نشده است.</h3>

                </div>

            @endforelse

        </div>

    </div>

</section>