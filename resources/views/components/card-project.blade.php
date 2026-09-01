<div class="company-card project-card">

    <div class="project-image">

        <img
            src="{{ asset($project['image'] ?? 'images/project.jpg') }}"
            alt="{{ $project['name'] ?? 'پروژه آسانسور' }}">

    </div>


    <h3>
        {{ $project['name'] ?? 'پروژه بدون نام' }}
    </h3>


    <div class="company-info">

        <span>

            <x-ui.icon name="location-dot" />

            {{ $project['city'] ?? 'نامشخص' }}

        </span>


        <span>

            <x-ui.icon name="building" />

            {{ $project['type'] ?? 'پروژه آسانسور' }}

        </span>

    </div>


    <div class="project-status">

        <span></span>

        {{ $project['status'] ?? 'فعال' }}

    </div>


    <a
        href="{{ !empty($project['slug']) ? route('project.profile', $project['slug']) : route('projects.index') }}"
        class="company-profile-btn">

        مشاهده پروژه

        <x-ui.icon name="arrow-left" />

    </a>


</div>
