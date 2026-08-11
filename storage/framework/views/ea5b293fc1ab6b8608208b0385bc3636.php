<section class="profile-stats">


    <div class="stats-card">


        <div class="stat-item">

            <i class="fa-solid fa-calendar-days"></i>

            <strong>

                <?php echo e($company->experience ?? 0); ?>


            </strong>

            <span>

                سال تجربه

            </span>

        </div>





        <div class="stat-item">

            <i class="fa-solid fa-building"></i>

            <strong>

                <?php echo e($company->projects_count ?? 0); ?>


            </strong>

            <span>

                پروژه انجام شده

            </span>

        </div>





        <div class="stat-item">

            <i class="fa-solid fa-star"></i>

            <strong>

                <?php echo e($company->rating ?? 0); ?>


            </strong>

            <span>

                امتیاز

            </span>

        </div>





        <div class="stat-item">

            <i class="fa-solid fa-comments"></i>

            <strong>

                <?php echo e($company->reviews_count ?? 0); ?>


            </strong>

            <span>

                نظر ثبت شده

            </span>

        </div>



    </div>


</section>
<?php /**PATH D:\AsansorPRO\marketplace\resources\views/pages/profile/company/sections/stats.blade.php ENDPATH**/ ?>