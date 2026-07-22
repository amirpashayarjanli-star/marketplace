<div class="project-card">

    <div class="project-card-top">

        <span class="project-status status-open">

            {{ $project->status ?? 'فعال' }}

        </span>

        <span class="project-date">

            {{ $project->created_at?->diffForHumans() ?? 'همین الان' }}

        </span>

    </div>

    <h3 class="project-title">

        {{ $project->title }}

    </h3>

    <div class="project-location">

        <i class="fa-solid fa-location-dot"></i>

        {{ $project->city }}

    </div>

    <div class="project-meta">

        <div>

            <i class="fa-solid fa-building"></i>

            {{ $project->building_type }}

        </div>

        <div>

            <i class="fa-solid fa-elevator"></i>

            {{ $project->elevator_count }} دستگاه

        </div>

    </div>

    <div class="project-footer">

        <span class="project-budget">

            {{ number_format($project->budget) }}

            تومان

        </span>

        <a href="#">

            مشاهده

        </a>

    </div>

</div>