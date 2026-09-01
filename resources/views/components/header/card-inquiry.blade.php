<div class="project-card">

    <div class="project-card-top">

        <span class="project-status status-open">

            {{ $inquiry->status ?? 'جدید' }}

        </span>

        <span class="project-date">

            {{ $inquiry->created_at?->diffForHumans() ?? 'همین الان' }}

        </span>

    </div>

    <h3 class="project-title">

        {{ $inquiry->title }}

    </h3>

    <div class="project-location">

        <x-ui.icon name="layer-group" />

        {{ $inquiry->category ?? 'قطعات آسانسور' }}

    </div>

    <div class="project-meta">

        <div>

            <x-ui.icon name="cubes" />

            {{ $inquiry->quantity ?? 1 }} عدد

        </div>

        <div>

            <x-ui.icon name="location-dot" />

            {{ $inquiry->city ?? '---' }}

        </div>

    </div>

    <div class="project-footer">

        <span class="project-budget">

            {{ $inquiry->price ? number_format($inquiry->price).' تومان' : 'توافقی' }}

        </span>

        <a href="#" title="درحال تکمیل">

            مشاهده

        </a>

    </div>

</div>