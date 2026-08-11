<?php $__env->startSection('title','شرکت های آسانسوری'); ?>


<?php $__env->startSection('content'); ?>


<?php echo $__env->make('sections.header-inner', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>



<main class="directory-page">



    <section class="directory-top">


        <h1>
            شرکت‌های آسانسوری ایران
        </h1>


        <p>
            بهترین شرکت‌های آسانسوری را پیدا کنید
        </p>


    </section>




    <?php if (isset($component)) { $__componentOriginalab4f52eb4c6f93a845317dcbd25041bf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalab4f52eb4c6f93a845317dcbd25041bf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.directory.filter-box','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('directory.filter-box'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalab4f52eb4c6f93a845317dcbd25041bf)): ?>
<?php $attributes = $__attributesOriginalab4f52eb4c6f93a845317dcbd25041bf; ?>
<?php unset($__attributesOriginalab4f52eb4c6f93a845317dcbd25041bf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalab4f52eb4c6f93a845317dcbd25041bf)): ?>
<?php $component = $__componentOriginalab4f52eb4c6f93a845317dcbd25041bf; ?>
<?php unset($__componentOriginalab4f52eb4c6f93a845317dcbd25041bf); ?>
<?php endif; ?>




    <div class="company-grid">


        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>


            <?php if (isset($component)) { $__componentOriginal2b5d0b114d75f505210cc22dd54aca06 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2b5d0b114d75f505210cc22dd54aca06 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.directory.company-card','data' => ['company' => $company]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('directory.company-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['company' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($company)]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2b5d0b114d75f505210cc22dd54aca06)): ?>
<?php $attributes = $__attributesOriginal2b5d0b114d75f505210cc22dd54aca06; ?>
<?php unset($__attributesOriginal2b5d0b114d75f505210cc22dd54aca06); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2b5d0b114d75f505210cc22dd54aca06)): ?>
<?php $component = $__componentOriginal2b5d0b114d75f505210cc22dd54aca06; ?>
<?php unset($__componentOriginal2b5d0b114d75f505210cc22dd54aca06); ?>
<?php endif; ?>


        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>


    </div>



</main>



<?php echo $__env->make('sections.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\AsansorPRO\marketplace\resources\views/pages/companies/index.blade.php ENDPATH**/ ?>