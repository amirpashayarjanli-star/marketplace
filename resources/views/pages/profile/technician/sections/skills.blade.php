<?php
    // مهارت‌ها در ستون text و جداشده با ویرگول ذخیره می‌شوند.
    $skillList = collect(
            is_array($technician->skills)
                ? $technician->skills
                : preg_split('/[،,]/u', (string) $technician->skills)
        )
        ->map(fn ($skill) => trim((string) $skill))
        ->filter()
        ->values();
?>

@if($skillList->isNotEmpty())

<section class="profile-skills">


    <div class="profile-section-card">


        <div class="section-title">

            <x-ui.icon name="screwdriver-wrench" />

            مهارت‌ها و تخصص‌ها

        </div>


        <div class="skills-grid">

            @foreach($skillList as $skill)

            <div class="skill-card">

                <x-ui.icon name="screwdriver-wrench" />

                <h3>
                    {{ $skill }}
                </h3>

            </div>

            @endforeach

        </div>


    </div>


</section>

@endif
