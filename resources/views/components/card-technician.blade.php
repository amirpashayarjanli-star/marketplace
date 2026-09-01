<div class="company-card technician-card">

    <div class="company-logo">

        <img
            src="{{ $technician->avatar ? asset($technician->avatar) : asset('images/default-avatar.png') }}"
            alt="{{ $technician->name }}">

    </div>


    <h3>
        {{ $technician->name }}
    </h3>


    <div class="company-info">

        <span>
            <x-ui.icon name="location-dot" />
            {{ $technician->city }}
        </span>


        <span>
            <x-ui.icon name="star" />
            {{ $technician->rating ?? 0 }}
        </span>

    </div>


    <div class="technician-skills">

        {{ $technician->skill ?? 'تکنسین آسانسور' }}

    </div>


    <a href="{{ route('technician.profile', $technician->slug) }}"
       class="company-profile-btn">

        مشاهده پروفایل

        <x-ui.icon name="arrow-left" />

    </a>

</div>
