<section class="profile-products">


    <div class="section-title">

        <h2>

            محصولات

        </h2>

    </div>





    <div class="products-grid">


        @if($manufacturer->products && $manufacturer->products->count())


            @foreach($manufacturer->products as $product)


                <div class="product-card">


                    @if($product->image)

                    <div class="product-image">


                        <img

                        src="{{ asset($product->image) }}"

                        alt="{{ $product->name }}">


                    </div>

                    @endif





                    <h3>

                        {{ $product->name }}

                    </h3>





                    @if($product->category)

                    <span>

                        {{ $product->category }}

                    </span>

                    @endif



                </div>


            @endforeach


        @else


            <div class="empty-data">

                محصولی ثبت نشده است.

            </div>


        @endif



    </div>


</section>
