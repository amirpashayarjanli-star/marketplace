<div class="company-card">


    <div class="company-logo">

        <img
            src="<?php echo e($company->logo ? asset($company->logo) : asset('images/default-logo.png')); ?>"
            alt="<?php echo e($company->name); ?>">

    </div>


    <h3>
        <?php echo e($company->name); ?>

    </h3>


    <div class="company-info">


        <span>

            <i class="fa-solid fa-location-dot"></i>

            <?php echo e($company->city); ?>


        </span>


        <span>

            <i class="fa-solid fa-star"></i>

            <?php echo e($company->rating ?? 0); ?>


        </span>


    </div>


    <div class="company-comments">

        <i class="fa-solid fa-comments"></i>

        <?php echo e($company->reviews_count ?? 0); ?> نظر

    </div>



    <a href="<?php echo e(route('company.profile', $company->slug)); ?>"
       class="company-profile-btn">


        مشاهده پروفایل


        <i class="fa-solid fa-arrow-left"></i>


    </a>


</div>
<?php /**PATH D:\AsansorPRO\marketplace\resources\views/components/card-company.blade.php ENDPATH**/ ?>