<section class="mobile-hero-card">


    

    <div class="mobile-header-overlay">

        <?php echo $__env->make('mobile.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    </div>




    

    <div class="mobile-hero-image">

        <img
        src="<?php echo e(asset('images/hero/mobile-hero.webp')); ?>"
        alt="آسانسور پرو">

    </div>





    

    <div class="mobile-hero-content">


        <span class="mobile-hero-badge">

            آسانسور پرو

        </span>




        <h1>

            شروع هر پروژه از


            <br>


            <span class="text-blue-700">

                آسانسور

            </span>


            <span class="text-yellow-500">

                پرو

            </span>


        </h1>


    </div>





    

    <?php if (isset($component)) { $__componentOriginal126fa72f35d94cee5bb324b9474d7be5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal126fa72f35d94cee5bb324b9474d7be5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.hero-dollar','data' => ['dollar' => $dollar]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('hero-dollar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['dollar' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($dollar)]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal126fa72f35d94cee5bb324b9474d7be5)): ?>
<?php $attributes = $__attributesOriginal126fa72f35d94cee5bb324b9474d7be5; ?>
<?php unset($__attributesOriginal126fa72f35d94cee5bb324b9474d7be5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal126fa72f35d94cee5bb324b9474d7be5)): ?>
<?php $component = $__componentOriginal126fa72f35d94cee5bb324b9474d7be5; ?>
<?php unset($__componentOriginal126fa72f35d94cee5bb324b9474d7be5); ?>
<?php endif; ?>




    

    <?php echo $__env->make('mobile.trust-bar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>



</section>
<?php /**PATH D:\AsansorPRO\marketplace\resources\views/mobile/hero.blade.php ENDPATH**/ ?>