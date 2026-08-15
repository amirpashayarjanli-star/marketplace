<div class="company-card technician-card">

    <div class="company-logo">

        <img
            src="<?php echo e($technician->avatar ? asset($technician->avatar) : asset('images/default-avatar.png')); ?>"
            alt="<?php echo e($technician->name); ?>">

    </div>


    <h3>
        <?php echo e($technician->name); ?>

    </h3>


    <div class="company-info">

        <span>
            <i class="fa-solid fa-location-dot"></i>
            <?php echo e($technician->city); ?>

        </span>


        <span>
            <i class="fa-solid fa-star"></i>
            <?php echo e($technician->rating ?? 0); ?>

        </span>

    </div>


    <div class="technician-skills">

        <?php echo e($technician->skill ?? 'تکنسین آسانسور'); ?>


    </div>


    <a href="<?php echo e(route('technician.profile', $technician->slug)); ?>"
       class="company-profile-btn">

        مشاهده پروفایل

        <i class="fa-solid fa-arrow-left"></i>

    </a>

</div>
<?php /**PATH D:\AsansorPRO\marketplace\resources\views/components/card-technician.blade.php ENDPATH**/ ?>