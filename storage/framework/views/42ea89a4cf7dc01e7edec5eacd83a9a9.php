<header class="fixed inset-x-0 top-0 z-50 pt-5">

    <div class="container-app">

        <div class="glass-premium radius-xl flex h-20 items-center justify-between px-6">

            
            <?php if (isset($component)) { $__componentOriginal6c5d473d64c1043297d005c9086d06d0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6c5d473d64c1043297d005c9086d06d0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.header.logo','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('header.logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6c5d473d64c1043297d005c9086d06d0)): ?>
<?php $attributes = $__attributesOriginal6c5d473d64c1043297d005c9086d06d0; ?>
<?php unset($__attributesOriginal6c5d473d64c1043297d005c9086d06d0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6c5d473d64c1043297d005c9086d06d0)): ?>
<?php $component = $__componentOriginal6c5d473d64c1043297d005c9086d06d0; ?>
<?php unset($__componentOriginal6c5d473d64c1043297d005c9086d06d0); ?>
<?php endif; ?>


            
            <div class="hidden lg:block">
                <?php if (isset($component)) { $__componentOriginal5d07ae629f5938ce59c77e5dcb7f224b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5d07ae629f5938ce59c77e5dcb7f224b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.header.navigation','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('header.navigation'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5d07ae629f5938ce59c77e5dcb7f224b)): ?>
<?php $attributes = $__attributesOriginal5d07ae629f5938ce59c77e5dcb7f224b; ?>
<?php unset($__attributesOriginal5d07ae629f5938ce59c77e5dcb7f224b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5d07ae629f5938ce59c77e5dcb7f224b)): ?>
<?php $component = $__componentOriginal5d07ae629f5938ce59c77e5dcb7f224b; ?>
<?php unset($__componentOriginal5d07ae629f5938ce59c77e5dcb7f224b); ?>
<?php endif; ?>
            </div>


            
            <?php if (isset($component)) { $__componentOriginal2d0ed8de40935a4a8de093f1d28f3c23 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2d0ed8de40935a4a8de093f1d28f3c23 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.header.mobile-menu','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('header.mobile-menu'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2d0ed8de40935a4a8de093f1d28f3c23)): ?>
<?php $attributes = $__attributesOriginal2d0ed8de40935a4a8de093f1d28f3c23; ?>
<?php unset($__attributesOriginal2d0ed8de40935a4a8de093f1d28f3c23); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2d0ed8de40935a4a8de093f1d28f3c23)): ?>
<?php $component = $__componentOriginal2d0ed8de40935a4a8de093f1d28f3c23; ?>
<?php unset($__componentOriginal2d0ed8de40935a4a8de093f1d28f3c23); ?>
<?php endif; ?>


            
            <div class="header-actions flex items-center gap-4">

                <?php if (isset($component)) { $__componentOriginalf136e979acf870eede27552f8737ba12 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf136e979acf870eede27552f8737ba12 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.header.search','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('header.search'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf136e979acf870eede27552f8737ba12)): ?>
<?php $attributes = $__attributesOriginalf136e979acf870eede27552f8737ba12; ?>
<?php unset($__attributesOriginalf136e979acf870eede27552f8737ba12); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf136e979acf870eede27552f8737ba12)): ?>
<?php $component = $__componentOriginalf136e979acf870eede27552f8737ba12; ?>
<?php unset($__componentOriginalf136e979acf870eede27552f8737ba12); ?>
<?php endif; ?>


                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(route('dashboard')); ?>"
                       class="btn btn-primary">
                        داشبورد
                    </a>
                <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>"
                       class="btn btn-primary">
                        ورود | ثبت‌نام
                    </a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            </div>


        </div>

    </div>

</header><?php /**PATH D:\AsansorPRO\marketplace\resources\views/sections/header.blade.php ENDPATH**/ ?>