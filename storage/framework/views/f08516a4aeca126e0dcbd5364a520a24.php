<aside class="w-72 bg-white shadow-lg min-h-screen p-5">

    <h2 class="text-2xl font-bold mb-8">
        <span class="text-blue-600">
            آسانسور
        </span>
        <span class="text-yellow-500">
            پرو
        </span>
    </h2>

    <nav class="space-y-2">

        <a href="<?php echo e(route('dashboard')); ?>"
           class="block p-3 rounded-xl hover:bg-gray-100 transition">
            🏠 داشبورد
        </a>

        <a href="<?php echo e(route('dashboard.profile')); ?>"
           class="block p-3 rounded-xl hover:bg-gray-100 transition">
            👤 پروفایل
        </a>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->type == 'company'): ?>
            <a href="<?php echo e(route('dashboard.projects')); ?>" class="block p-3 rounded-xl hover:bg-gray-100 transition">
                📁 پروژه‌های من
            </a>

        <?php elseif(auth()->user()->type == 'manufacturer'): ?>
            <!-- Coming soon features: محصولات، برندها -->

        <?php elseif(auth()->user()->type == 'store'): ?>
            <!-- Coming soon features: محصولات، برندها -->

        <?php elseif(auth()->user()->type == 'technician'): ?>
            <!-- Coming soon features: کارهای من، سوابق کاری -->

        <?php elseif(auth()->user()->type == 'employer'): ?>
            <a href="<?php echo e(route('dashboard.projects.create')); ?>" class="block p-3 rounded-xl hover:bg-gray-100 transition">
                ➕ ثبت پروژه جدید
            </a>

            <a href="<?php echo e(route('dashboard.projects')); ?>" class="block p-3 rounded-xl hover:bg-gray-100 transition">
                📁 پروژه‌های من
            </a>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <hr class="my-5">

        <!-- Coming soon: پیام‌ها و تنظیمات -->

    </nav>

</aside>
<?php /**PATH D:\AsansorPRO\marketplace\resources\views/dashboard/partials/sidebar.blade.php ENDPATH**/ ?>