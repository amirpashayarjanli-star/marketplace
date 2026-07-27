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

            <i class="fa-solid fa-location-dot"></i>

            {{ $project['city'] ?? 'نامشخص' }}

        </span>


        <span>

            <i class="fa-solid fa-building"></i>

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

        <i class="fa-solid fa-arrow-left"></i>

    </a>


</div>
