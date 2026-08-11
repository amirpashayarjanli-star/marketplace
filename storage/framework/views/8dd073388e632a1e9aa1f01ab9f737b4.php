<section class="profile-hero">


    <div class="profile-hero-card">



        <div class="profile-logo">


            <img

            src="<?php echo e(asset($company->logo ?? 'images/logo/logo.svg')); ?>"

            alt="<?php echo e($company->name); ?>">


        </div>





        <div class="profile-info">



            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($company->is_verified): ?>

            <div class="profile-verified">


                <i class="fa-solid fa-circle-check"></i>


                تایید شده آسانسور پرو


            </div>

            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>






            <h1>

                <?php echo e($company->name); ?>


            </h1>







            <div class="profile-meta">



                <span>

                    <i class="fa-solid fa-location-dot"></i>

                    <?php echo e($company->city); ?>


                </span>





                <span>

                    <i class="fa-solid fa-star"></i>

                    <?php echo e($company->rating ?? 0); ?>


                </span>





                <span>

                    <i class="fa-solid fa-comments"></i>

                    <?php echo e($company->reviews_count ?? 0); ?> نظر

                </span>



            </div>








            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($company->services): ?>


            <div class="manufacturer-tags">


                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $company->services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>


                <span>

                    <?php echo e($service->name); ?>


                </span>


                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>


            </div>


            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>







            <div class="profile-actions">



                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($company->phone || $company->mobile): ?>

                <a href="tel:<?php echo e($company->phone ?? $company->mobile); ?>"

                   class="btn-primary">


                    تماس با شرکت


                </a>

                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>





                <a href="#contact"

                   class="btn-secondary">


                    درخواست همکاری


                </a>



            </div>





        </div>




    </div>



</section>
<?php /**PATH D:\AsansorPRO\marketplace\resources\views/pages/profile/company/sections/hero.blade.php ENDPATH**/ ?>