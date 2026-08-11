<section class="profile-projects">


    <div class="section-title">

        <h2>

            پروژه‌ها

        </h2>

    </div>





    <div class="projects-grid">


        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($company->projects && $company->projects->count()): ?>


            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $company->projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>


                <div class="project-card">


                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($project->image): ?>

                    <div class="project-image">


                        <img

                        src="<?php echo e(asset($project->image)); ?>"

                        alt="<?php echo e($project->title); ?>">


                    </div>

                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>





                    <h3>

                        <?php echo e($project->title); ?>


                    </h3>





                    <div class="project-meta">


                        <span>

                            <i class="fa-solid fa-location-dot"></i>

                            <?php echo e($project->city); ?>


                        </span>



                        <span>

                            <i class="fa-solid fa-building"></i>

                            <?php echo e($project->type); ?>


                        </span>


                    </div>



                </div>


            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>


        <?php else: ?>


            <div class="empty-data">

                پروژه‌ای ثبت نشده است.

            </div>


        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>



    </div>


</section>
<?php /**PATH D:\AsansorPRO\marketplace\resources\views/pages/profile/company/sections/projects.blade.php ENDPATH**/ ?>