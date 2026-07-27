<section class="section latest-projects">

<div class="container">


<div class="section-header flex justify-between items-center mb-6">


<x-section-title
title="آخرین پروژه‌ها"
subtitle="پروژه‌های ثبت شده"
/>


<a href="{{ route('projects.index') }}"
class="btn btn-primary">
مشاهده همه
</a>


</div>


<div class="grid grid-cols-1 md:grid-cols-3 gap-6">


@forelse($latestProjects ?? [] as $project)


<x-card-project :project="$project"/>


@empty

<p>پروژه‌ای ثبت نشده است.</p>

@endforelse


</div>


</div>

</section>
