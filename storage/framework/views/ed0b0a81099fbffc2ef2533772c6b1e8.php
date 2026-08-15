<?php $__env->startSection('content'); ?>

<div class="min-h-screen py-8 px-4">
    
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-2">
            ✏️ ویرایش پروفایل فروشگاه
        </h1>
        <p class="text-gray-600">
            اطلاعات فروشگاه خود را بروزرسانی کنید
        </p>
    </div>

    
    <div class="backdrop-blur-xl bg-white/80 border border-white/40 rounded-3xl shadow-xl p-8 md:p-10 max-w-4xl">

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
            <div class="bg-gradient-to-r from-green-500/20 to-emerald-500/20 border border-green-500/50 text-green-700 p-4 rounded-2xl mb-6 flex items-start gap-3">
                <i class="fa-solid fa-circle-check mt-1 flex-shrink-0 text-green-600"></i>
                <div><?php echo e(session('success')); ?></div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
            <div class="bg-gradient-to-r from-red-500/20 to-pink-500/20 border border-red-500/50 text-red-700 p-4 rounded-2xl mb-6">
                <div class="flex items-start gap-3">
                    <i class="fa-solid fa-circle-exclamation mt-1 flex-shrink-0 text-red-600"></i>
                    <div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <div><?php echo e($error); ?></div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($profile): ?>
            <form method="POST" action="<?php echo e(route('dashboard.profile.update')); ?>" class="space-y-6">
                <?php echo csrf_field(); ?>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <div class="relative group">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                            <i class="fa-solid fa-shop text-green-600 group-focus-within:text-green-500 transition"></i>
                        </div>
                        <input
                            type="text"
                            name="name"
                            value="<?php echo e($profile->name); ?>"
                            placeholder="نام فروشگاه"
                            class="w-full bg-white/50 border border-white/60 rounded-2xl px-5 py-3.5 pr-12 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent backdrop-blur-sm transition-all <?php echo e($errors->has('name') ? 'ring-2 ring-red-500' : ''); ?>"
                            required
                        >
                        <label class="absolute -top-2.5 right-4 text-xs font-semibold bg-white/80 px-2 text-gray-700">
                            نام فروشگاه
                        </label>
                    </div>

                    
                    <div class="relative group">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                            <i class="fa-solid fa-user text-green-600 group-focus-within:text-green-500 transition"></i>
                        </div>
                        <input
                            type="text"
                            name="manager_name"
                            value="<?php echo e($profile->manager_name); ?>"
                            placeholder="نام مدیر یا صاحب"
                            class="w-full bg-white/50 border border-white/60 rounded-2xl px-5 py-3.5 pr-12 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent backdrop-blur-sm transition-all"
                        >
                        <label class="absolute -top-2.5 right-4 text-xs font-semibold bg-white/80 px-2 text-gray-700">
                            نام مدیر
                        </label>
                    </div>

                    
                    <div class="relative group">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                            <i class="fa-solid fa-phone text-green-600 group-focus-within:text-green-500 transition"></i>
                        </div>
                        <input
                            type="tel"
                            name="phone"
                            value="<?php echo e($profile->phone); ?>"
                            placeholder="021-12345678"
                            inputmode="numeric"
                            pattern="[0-9\s\-\+\(\)]{10,20}"
                            class="w-full bg-white/50 border border-white/60 rounded-2xl px-5 py-3.5 pr-12 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent backdrop-blur-sm transition-all <?php echo e($errors->has('phone') ? 'ring-2 ring-red-500' : ''); ?>"
                        >
                        <label class="absolute -top-2.5 right-4 text-xs font-semibold bg-white/80 px-2 text-gray-700">
                            شماره تماس
                        </label>
                    </div>

                    
                    <div class="relative group">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none z-10">
                            <i class="fa-solid fa-map-location-dot text-green-600 group-focus-within:text-green-500 transition"></i>
                        </div>
                        <select
                            name="city"
                            class="w-full bg-white/50 border border-white/60 rounded-2xl px-5 py-3.5 pr-12 text-gray-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent backdrop-blur-sm transition-all <?php echo e($errors->has('city') ? 'ring-2 ring-red-500' : ''); ?>"
                        >
                            <option value="">انتخاب شهر...</option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = \App\Enums\IranianCity::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <option value="<?php echo e($key); ?>" <?php echo e($profile->city === $key ? 'selected' : ''); ?>><?php echo e($city); ?></option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </select>
                        <label class="absolute -top-2.5 right-4 text-xs font-semibold bg-white/80 px-2 text-gray-700">
                            شهر
                        </label>
                    </div>

                    
                    <div class="relative group">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                            <i class="fa-solid fa-map text-green-600 group-focus-within:text-green-500 transition"></i>
                        </div>
                        <input
                            type="text"
                            name="province"
                            value="<?php echo e($profile->province); ?>"
                            placeholder="استان"
                            class="w-full bg-white/50 border border-white/60 rounded-2xl px-5 py-3.5 pr-12 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent backdrop-blur-sm transition-all"
                        >
                        <label class="absolute -top-2.5 right-4 text-xs font-semibold bg-white/80 px-2 text-gray-700">
                            استان
                        </label>
                    </div>

                    
                    <div class="relative group">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                            <i class="fa-solid fa-briefcase text-green-600 group-focus-within:text-green-500 transition"></i>
                        </div>
                        <input
                            type="number"
                            name="experience"
                            value="<?php echo e($profile->experience); ?>"
                            placeholder="سال"
                            min="0"
                            class="w-full bg-white/50 border border-white/60 rounded-2xl px-5 py-3.5 pr-12 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent backdrop-blur-sm transition-all"
                        >
                        <label class="absolute -top-2.5 right-4 text-xs font-semibold bg-white/80 px-2 text-gray-700">
                            سابقه فعالیت (سال)
                        </label>
                    </div>
                </div>

                
                <div class="relative group">
                    <div class="absolute top-4 right-0 flex items-center pr-4 pointer-events-none">
                        <i class="fa-solid fa-envelope text-green-600 group-focus-within:text-green-500 transition"></i>
                    </div>
                    <input
                        type="email"
                        name="email"
                        value="<?php echo e($profile->email); ?>"
                        placeholder="ایمیل"
                        class="w-full bg-white/50 border border-white/60 rounded-2xl px-5 py-3.5 pr-12 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent backdrop-blur-sm transition-all <?php echo e($errors->has('email') ? 'ring-2 ring-red-500' : ''); ?>"
                    >
                    <label class="absolute -top-2.5 right-4 text-xs font-semibold bg-white/80 px-2 text-gray-700">
                        ایمیل
                    </label>
                </div>

                
                <div class="relative group">
                    <div class="absolute top-4 right-0 flex items-center pr-4 pointer-events-none">
                        <i class="fa-solid fa-globe text-green-600 group-focus-within:text-green-500 transition"></i>
                    </div>
                    <input
                        type="url"
                        name="website"
                        value="<?php echo e($profile->website); ?>"
                        placeholder="https://example.com"
                        class="w-full bg-white/50 border border-white/60 rounded-2xl px-5 py-3.5 pr-12 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent backdrop-blur-sm transition-all"
                    >
                    <label class="absolute -top-2.5 right-4 text-xs font-semibold bg-white/80 px-2 text-gray-700">
                        وب سایت
                    </label>
                </div>

                
                <div class="relative group">
                    <div class="absolute top-4 right-0 flex items-center pr-4 pointer-events-none">
                        <i class="fa-solid fa-location-dot text-green-600 group-focus-within:text-green-500 transition"></i>
                    </div>
                    <textarea
                        name="address"
                        placeholder="آدرس کامل"
                        rows="3"
                        class="w-full bg-white/50 border border-white/60 rounded-2xl px-5 py-3.5 pr-12 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent backdrop-blur-sm transition-all"
                    ><?php echo e($profile->address); ?></textarea>
                    <label class="absolute -top-2.5 right-4 text-xs font-semibold bg-white/80 px-2 text-gray-700">
                        آدرس
                    </label>
                </div>

                
                <div class="relative group">
                    <div class="absolute top-4 right-0 flex items-center pr-4 pointer-events-none">
                        <i class="fa-solid fa-align-left text-green-600 group-focus-within:text-green-500 transition"></i>
                    </div>
                    <textarea
                        name="description"
                        placeholder="درباره فروشگاه خود توضیح دهید"
                        rows="5"
                        class="w-full bg-white/50 border border-white/60 rounded-2xl px-5 py-3.5 pr-12 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent backdrop-blur-sm transition-all"
                    ><?php echo e($profile->description); ?></textarea>
                    <label class="absolute -top-2.5 right-4 text-xs font-semibold bg-white/80 px-2 text-gray-700">
                        توضیحات
                    </label>
                </div>

                
                <button
                    type="submit"
                    class="w-full bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold py-3.5 rounded-2xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg active:scale-95 flex items-center justify-center gap-2 mt-8"
                >
                    <span>💾 ذخیره تغییرات</span>
                    <i class="fa-solid fa-arrow-left"></i>
                </button>
            </form>

        <?php else: ?>
            <div class="text-center py-12">
                <i class="fa-solid fa-info-circle text-3xl text-gray-400 mb-4"></i>
                <p class="text-gray-600 text-lg">
                    پروفایل فروشگاه یافت نشد.
                </p>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    </div>

</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('dashboard.layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\AsansorPRO\marketplace\resources\views/dashboard/profile/store.blade.php ENDPATH**/ ?>