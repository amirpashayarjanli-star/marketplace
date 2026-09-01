<section class="profile-reviews">

    <div class="section-title">
        <h2>
            نظرات کاربران
        </h2>
    </div>


    <div class="reviews-list">

        @php
            $approvedReviews = $company->reviews->where('is_verified', true);
        @endphp


        @if($approvedReviews->count())

            @foreach($approvedReviews as $review)

                <div class="review-item">

                    <div class="review-header">

                        <strong>
                            {{ $review->name }}
                        </strong>

                        <span>
                            <x-ui.icon name="star" />
                            {{ $review->rating }}
                        </span>

                    </div>


                    <p>
                        {{ $review->comment }}
                    </p>

                </div>

            @endforeach

        @else

            <div class="empty-data">
                نظری ثبت نشده است.
            </div>

        @endif


    </div>


    <div class="review-form">
        <livewire:review-form :model="$company" />
    </div>


</section>
