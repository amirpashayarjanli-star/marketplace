<section class="profile-reviews">


    <div class="section-title">

        <h2>

            نظرات کاربران

        </h2>

    </div>





    <div class="reviews-list">


        @if($technician->reviews && $technician->reviews->count())


            @foreach($technician->reviews as $review)


                <div class="review-item">


                    <div class="review-header">


                        <strong>

                            {{ $review->name }}

                        </strong>




                        <span>

                            <i class="fa-solid fa-star"></i>

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


</section>
