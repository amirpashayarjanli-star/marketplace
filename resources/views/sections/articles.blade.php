<section id="articles" class="latest-articles">

    <div class="container-app">

        <x-section-title
            title="آخرین مقالات"
            description="جدیدترین مقالات، آموزش‌ها و اخبار صنعت آسانسور"
        />

        <div class="articles-grid">

            @forelse($latestArticles ?? [] as $article)

                @include('components.card-article', ['article' => $article])

            @empty

                <div class="slider-empty">

                    <x-ui.icon name="newspaper" />

                    <h3>
                        هنوز مقاله‌ای منتشر نشده است.
                    </h3>

                </div>

            @endforelse

        </div>

    </div>

</section>
