<section class="profile-contact">


    <div class="section-title">

        <h2>

            ارتباط با شرکت

        </h2>

    </div>





    <div class="contact-info">


        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($company->phone): ?>

        <div class="contact-item">

            <i class="fa-solid fa-phone"></i>

            <a href="tel:<?php echo e($company->phone); ?>">

                <?php echo e($company->phone); ?>


            </a>

        </div>

        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>





        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($company->mobile): ?>

        <div class="contact-item">

            <i class="fa-solid fa-mobile-screen"></i>

            <a href="tel:<?php echo e($company->mobile); ?>">

                <?php echo e($company->mobile); ?>


            </a>

        </div>

        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>





        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($company->website): ?>

        <div class="contact-item">

            <i class="fa-solid fa-globe"></i>

            <a href="<?php echo e($company->website); ?>" target="_blank">

                وب‌سایت شرکت

            </a>

        </div>

        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>





        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($company->address): ?>

        <div class="contact-item">

            <i class="fa-solid fa-location-dot"></i>

            <span>

                <?php echo e($company->address); ?>


            </span>

        </div>

        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>



    </div>


</section>
<?php /**PATH D:\AsansorPRO\marketplace\resources\views/pages/profile/company/sections/contact.blade.php ENDPATH**/ ?>