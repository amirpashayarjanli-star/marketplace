<section class="latest-projects">

    <div class="container-app">

        <x-section-title
            title="آخرین پروژه‌ها"
            description="جدیدترین پروژه‌های ثبت شده در آسانسور پرو"
        />

        <div class="latest-projects-grid">

            @forelse($latestProjects ?? [] as $project)

                <x-directory.project-card :project="$project" />

            @empty

                <div class="slider-empty">

                    <x-ui.icon name="folder-open" />

                    <h3>
                        هنوز پروژه‌ای ثبت نشده است.
                    </h3>

                </div>

            @endforelse

        </div>

    </div>

</section>
