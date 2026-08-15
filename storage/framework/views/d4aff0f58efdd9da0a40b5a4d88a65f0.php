<div class="company-card store-card">


    <div class="company-logo">

        <img
            src="<?php echo e($store->logo ? asset($store->logo) : asset('images/default-logo.png')); ?>"
            alt="<?php echo e($store->name); ?>">

    </div>


    <h3>
        <?php echo e($store->name); ?>

    </h3>


    <div class="store-type">

        <i class="fa-solid fa-store"></i>

        فروشگاه قطعات آسانسور

    </div>


    <div class="company-info">


        <span>

            <i class="fa-solid fa-location-dot"></i>

            <?php echo e($store->city); ?>


        </span>


        <span>

            <i class="fa-solid fa-star"></i>

            <?php echo e($store->rating ?? 0); ?>


        </span>


    </div>



    <div class="store-products">

        <span>
            موتور
        </span>

        <span>
            تابلو فرمان
        </span>

        <span>
            درب آسانسور
        </span>

    </div>



    <div class="company-comments">

        <i class="fa-solid fa-comments"></i>

        <?php echo e($store->reviews_count ?? 0); ?> نظر

    </div>



    <a href="<?php echo e(route('store.profile', $store->slug)); ?>"
       class="company-profile-btn">


        مشاهده فروشگاه


        <i class="fa-solid fa-arrow-left"></i>


    </a>


</div>
<?php /**PATH D:\AsansorPRO\marketplace\resources\views/components/card-store.blade.php ENDPATH**/ ?>