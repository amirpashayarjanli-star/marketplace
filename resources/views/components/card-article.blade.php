<div class="article-card">

    <div class="article-image">

        <img
            src="{{ $article->image ?? asset('images/article.jpg') }}"
            alt="{{ $article->title }}"
            loading="lazy">

        <span class="article-category">

            {{ $article->category ?? 'آموزش' }}

        </span>

    </div>

    <div class="article-body">

        <h3>

            {{ $article->title }}

        </h3>

        <p>

            {{ \Illuminate\Support\Str::limit($article->excerpt ?? '',100) }}

        </p>

        <div class="article-footer">

            <span>

                <i class="fa-regular fa-calendar"></i>

                {{ $article->created_at?->diffForHumans() ?? 'همین الان' }}

            </span>

            <a href="#" title="درحال تکمیل">

                ادامه مطلب

            </a>

        </div>

    </div>

</div>