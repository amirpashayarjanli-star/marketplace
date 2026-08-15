<div class="company-card manufacturer-card">


    <div class="company-logo">

        <img
            src="<?php echo e($manufacturer->logo ? asset($manufacturer->logo) : asset('images/default-logo.png')); ?>"
            alt="<?php echo e($manufacturer->name); ?>">

    </div>


    <h3>
        <?php echo e($manufacturer->name); ?>

    </h3>


    <div class="manufacturer-type">

        <i class="fa-solid fa-industry"></i>

        تولیدکننده تجهیزات آسانسور

    </div>


    <div class="company-info">


        <span>

            <i class="fa-solid fa-location-dot"></i>

            <?php echo e($manufacturer->city); ?>


        </span>


        <span>

            <i class="fa-solid fa-star"></i>

            <?php echo e($manufacturer->rating ?? 0); ?>


        </span>


    </div>



    <div class="manufacturer-products">

        <span>
            موتور آسانسور
        </span>

        <span>
            تابلو فرمان
        </span>

        <span>
            قطعات
        </span>

    </div>



    <div class="company-comments">

        <i class="fa-solid fa-comments"></i>

        <?php echo e($manufacturer->reviews_count ?? 0); ?> نظر

    </div>



    <a href="<?php echo e(route('manufacturer.profile', $manufacturer->slug)); ?>"
       class="company-profile-btn">


        مشاهده پروفایل


        <i class="fa-solid fa-arrow-left"></i>


    </a>


</div>
<?php /**PATH D:\AsansorPRO\marketplace\resources\views/components/card-manufacturer.blade.php ENDPATH**/ ?>