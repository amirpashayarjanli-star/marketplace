<section class="profile-products">


    <div class="profile-section-card">



        <div class="section-title">


            <i class="fa-solid fa-box"></i>


            محصولات فروشگاه



        </div>







        <div class="profile-product-grid">



            @forelse($store->products as $product)



                <div class="profile-product-card">



                    <div class="product-image">


                        <img

                        src="{{ asset($product->image ?? 'images/logo/company-logo.png') }}"

                        alt="{{ $product->name }}">


                    </div>







                    <h3>

                        {{ $product->name }}

                    </h3>







                    @if($product->brand)

                    <span>

                        <i class="fa-solid fa-tag"></i>

                        {{ $product->brand->name }}

                    </span>

                    @endif





                    @if($product->description)

                    <p>

                        {{ Str::limit($product->description, 80) }}

                    </p>

                    @endif



                </div>




            @empty



                <p>

                    هنوز محصولی برای این فروشگاه ثبت نشده است.

                </p>



            @endforelse





        </div>




    </div>


</section>
