<section class="profile-reviews">


    <div class="profile-section-card">



        <div class="section-title">


            <i class="fa-solid fa-star"></i>


            نظرات مشتریان



        </div>







        <div class="reviews-summary">


            <strong>

                {{ $manufacturer->rating }}

            </strong>



            <div>


                <div class="stars">

                    ★ ★ ★ ★ ★

                </div>


                <span>

                    {{ $manufacturer->reviews_count }} نظر

                </span>


            </div>



        </div>







        <div class="reviews-list">



            @forelse($manufacturer->reviews as $review)



                <div class="review-card">



                    <div class="review-header">


                        <strong>

                            {{ $review->name }}

                        </strong>



                        <span>

                            {{ str_repeat('★', $review->rating) }}

                        </span>


                    </div>





                    <p>

                        {{ $review->comment }}

                    </p>



                </div>



            @empty



                <p>

                    هنوز نظری ثبت نشده است.

                </p>



            @endforelse





        </div>




    </div>


</section>
