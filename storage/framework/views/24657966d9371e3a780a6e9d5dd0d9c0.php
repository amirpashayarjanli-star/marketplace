<?php
$items = [
    ['title' => 'خانه', 'url' => route('home')],
    ['title' => 'شرکت‌ها', 'url' => '#'],
    ['title' => 'تولیدکنندگان', 'url' => '#'],
    ['title' => 'فروشگاه‌ها', 'url' => '#'],
    ['title' => 'پروژه‌ها', 'url' => '#'],
    ['title' => 'مقالات', 'url' => '#'],
];
?>

<nav class="hidden lg:flex items-center">

    <ul class="flex items-center gap-1">

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>

            <li>

                <a href="<?php echo e($item['url']); ?>"
                   class="group relative flex h-11 items-center rounded-full px-5 text-[15px] font-semibold text-slate-700 transition duration-300 hover:text-blue-600">

                    <?php echo e($item['title']); ?>


                    <span class="absolute bottom-1 left-1/2 h-0.5 w-0 -translate-x-1/2 rounded-full bg-blue-600 transition-all duration-300 group-hover:w-8"></span>

                </a>

            </li>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

    </ul>

</nav><?php /**PATH D:\AsansorPRO\marketplace\resources\views/components/header/navigation.blade.php ENDPATH**/ ?>