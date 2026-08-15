<?php $__env->startSection('content'); ?>

<div class="min-h-screen flex items-center justify-center relative overflow-hidden py-8 px-4">
    
    <div class="absolute inset-0 -z-10">
        <div class="absolute top-0 right-0 w-96 h-96 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-yellow-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse" style="animation-delay: 2s;"></div>
    </div>

    <div class="w-full max-w-md">
        
        <div class="backdrop-blur-xl bg-white/30 border border-white/40 rounded-3xl shadow-2xl p-8 md:p-10">

            
            <div class="text-center mb-8">
                <img src="<?php echo e(asset('images/logo/logo-asansor-pro.png')); ?>" alt="آسانسور پرو" class="w-20 h-20 mx-auto mb-4 drop-shadow-lg">
                <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-yellow-500 bg-clip-text text-transparent">
                    ثبت نام
                </h1>
                <p class="text-gray-600 mt-2 text-sm">
                    به خانواده آسانسور پرو بپیوندید
                </p>
            </div>

            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
                <div class="bg-red-500/20 border border-red-500/50 backdrop-blur-sm text-red-700 p-4 rounded-2xl mb-6 text-sm">
                    <div class="flex items-start gap-3">
                        <i class="fa-solid fa-circle-exclamation mt-0.5 flex-shrink-0"></i>
                        <div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <div><?php echo e($error); ?></div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            
            <form method="POST" action="<?php echo e(route('register')); ?>" class="space-y-4">
                <?php echo csrf_field(); ?>

                
                <div class="relative group">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                        <i class="fa-solid fa-user text-blue-600 group-focus-within:text-yellow-500 transition"></i>
                    </div>
                    <input
                        type="text"
                        name="name"
                        value="<?php echo e(old('name')); ?>"
                        placeholder="نام شرکت یا نام شخصی"
                        class="w-full bg-white/50 border border-white/60 rounded-2xl px-5 py-3.5 pr-12 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent backdrop-blur-sm transition-all <?php echo e($errors->has('name') ? 'ring-2 ring-red-500' : ''); ?>"
                        required
                    >
                    <label class="absolute -top-2.5 right-4 text-xs font-semibold bg-white/80 px-2 text-gray-700">
                        نام
                    </label>
                </div>

                
                <div class="relative group">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                        <i class="fa-solid fa-phone text-blue-600 group-focus-within:text-yellow-500 transition"></i>
                    </div>
                    <input
                        type="tel"
                        name="mobile"
                        value="<?php echo e(old('mobile')); ?>"
                        placeholder="09123456789"
                        pattern="[0-9\s\-\+\(\)]{10,20}"
                        inputmode="numeric"
                        class="w-full bg-white/50 border border-white/60 rounded-2xl px-5 py-3.5 pr-12 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent backdrop-blur-sm transition-all <?php echo e($errors->has('mobile') ? 'ring-2 ring-red-500' : ''); ?>"
                        required
                    >
                    <label class="absolute -top-2.5 right-4 text-xs font-semibold bg-white/80 px-2 text-gray-700">
                        شماره موبایل
                    </label>
                </div>

                
                <div class="relative group">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                        <i class="fa-solid fa-lock text-blue-600 group-focus-within:text-yellow-500 transition"></i>
                    </div>
                    <button
                        type="button"
                        class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-600 hover:text-blue-600 transition toggle-password"
                        data-target="password-field"
                    >
                        <i class="fa-solid fa-eye text-sm"></i>
                    </button>
                    <input
                        id="password-field"
                        type="password"
                        name="password"
                        placeholder="رمز عبور (حداقل 8 کاراکتر)"
                        class="w-full bg-white/50 border border-white/60 rounded-2xl px-5 py-3.5 pr-12 pl-12 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent backdrop-blur-sm transition-all <?php echo e($errors->has('password') ? 'ring-2 ring-red-500' : ''); ?>"
                        required
                    >
                    <label class="absolute -top-2.5 right-4 text-xs font-semibold bg-white/80 px-2 text-gray-700">
                        رمز عبور
                    </label>
                </div>

                
                <div class="relative group">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                        <i class="fa-solid fa-lock-open text-blue-600 group-focus-within:text-yellow-500 transition"></i>
                    </div>
                    <button
                        type="button"
                        class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-600 hover:text-blue-600 transition toggle-password"
                        data-target="password-confirm-field"
                    >
                        <i class="fa-solid fa-eye text-sm"></i>
                    </button>
                    <input
                        id="password-confirm-field"
                        type="password"
                        name="password_confirmation"
                        placeholder="تکرار رمز عبور"
                        class="w-full bg-white/50 border border-white/60 rounded-2xl px-5 py-3.5 pr-12 pl-12 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent backdrop-blur-sm transition-all <?php echo e($errors->has('password_confirmation') ? 'ring-2 ring-red-500' : ''); ?>"
                        required
                    >
                    <label class="absolute -top-2.5 right-4 text-xs font-semibold bg-white/80 px-2 text-gray-700">
                        تکرار رمز عبور
                    </label>
                </div>

                
                <div id="password-strength" class="hidden">
                    <div class="flex gap-1 mb-2">
                        <div class="flex-1 h-1 bg-gray-300 rounded-full" id="strength-1"></div>
                        <div class="flex-1 h-1 bg-gray-300 rounded-full" id="strength-2"></div>
                        <div class="flex-1 h-1 bg-gray-300 rounded-full" id="strength-3"></div>
                    </div>
                    <p id="strength-text" class="text-xs font-medium"></p>
                </div>

                
                <label class="flex items-start gap-3 pt-2">
                    <input
                        type="checkbox"
                        name="terms"
                        class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-2 focus:ring-blue-500 mt-1"
                        required
                    >
                    <span class="text-xs text-gray-700">
                        با <a href="#" class="text-blue-600 hover:text-yellow-500 font-semibold">شرایط و ضوابط</a> و
                        <a href="#" class="text-blue-600 hover:text-yellow-500 font-semibold">سیاست حریم خصوصی</a> موافقم
                    </span>
                </label>

                
                <button
                    type="submit"
                    class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-yellow-600 text-white font-bold py-3.5 rounded-2xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg active:scale-95 flex items-center justify-center gap-2 mt-8"
                >
                    <span>ایجاد حساب کاربری</span>
                    <i class="fa-solid fa-arrow-left"></i>
                </button>
            </form>

            
            <div class="text-center mt-8 pt-6 border-t border-white/30">
                <p class="text-gray-700 text-sm">
                    قبلاً حساب داشتید؟
                    <a
                        href="<?php echo e(route('login')); ?>"
                        class="text-blue-600 font-bold hover:text-yellow-500 transition ml-1"
                    >
                        وارد شوید
                    </a>
                </p>
            </div>
        </div>

        
        <div class="mt-8 text-center text-xs text-gray-600">
            <div class="inline-flex items-center gap-4">
                <div class="flex items-center gap-1">
                    <i class="fa-solid fa-check-circle text-green-500"></i>
                    <span>رایگان</span>
                </div>
                <div class="flex items-center gap-1">
                    <i class="fa-solid fa-lightning text-yellow-500"></i>
                    <span>فوری</span>
                </div>
                <div class="flex items-center gap-1">
                    <i class="fa-solid fa-certificate text-blue-500"></i>
                    <span>معتبر</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Password toggle visibility
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.dataset.target;
            const input = document.getElementById(targetId);
            const icon = this.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });

    // Password strength indicator
    const passwordField = document.getElementById('password-field');
    const strengthIndicator = document.getElementById('password-strength');
    const strengthText = document.getElementById('strength-text');

    passwordField.addEventListener('input', function() {
        const password = this.value;
        let strength = 0;
        let text = '';
        let color = '';

        if (password.length >= 8) strength++;
        if (password.length >= 12) strength++;
        if (/[A-Z]/.test(password) && /[a-z]/.test(password)) strength++;
        if (/[0-9]/.test(password)) strength++;
        if (/[^A-Za-z0-9]/.test(password)) strength++;

        if (password.length === 0) {
            strengthIndicator.classList.add('hidden');
        } else {
            strengthIndicator.classList.remove('hidden');

            if (strength <= 1) {
                text = 'ضعیف';
                color = 'text-red-600';
                for (let i = 1; i <= 3; i++) {
                    document.getElementById('strength-' + i).style.backgroundColor = '#ef4444';
                }
            } else if (strength <= 2) {
                text = 'متوسط';
                color = 'text-yellow-600';
                document.getElementById('strength-1').style.backgroundColor = '#eab308';
                document.getElementById('strength-2').style.backgroundColor = '#eab308';
                document.getElementById('strength-3').style.backgroundColor = '#d1d5db';
            } else if (strength <= 3) {
                text = 'خوب';
                color = 'text-blue-600';
                document.getElementById('strength-1').style.backgroundColor = '#3b82f6';
                document.getElementById('strength-2').style.backgroundColor = '#3b82f6';
                document.getElementById('strength-3').style.backgroundColor = '#3b82f6';
            } else {
                text = 'قوی جداً';
                color = 'text-green-600';
                for (let i = 1; i <= 3; i++) {
                    document.getElementById('strength-' + i).style.backgroundColor = '#10b981';
                }
            }

            strengthText.className = `text-xs font-medium ${color}`;
            strengthText.textContent = text;
        }
    });
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\AsansorPRO\marketplace\resources\views/auth/register.blade.php ENDPATH**/ ?>