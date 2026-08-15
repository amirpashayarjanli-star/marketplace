<?php $__env->startSection('content'); ?>

<div class="min-h-screen flex items-center justify-center relative overflow-hidden py-8 px-4">
    
    <div class="absolute inset-0 -z-10">
        <div class="absolute top-0 right-0 w-96 h-96 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-yellow-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse" style="animation-delay: 2s;"></div>
    </div>

    <div class="w-full max-w-2xl">
        
        <div class="backdrop-blur-xl bg-white/30 border border-white/40 rounded-3xl shadow-2xl p-8 md:p-10">

            
            <div class="text-center mb-10">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-blue-600 to-yellow-500 rounded-2xl mb-4">
                    <i class="fa-solid fa-object-group text-white text-2xl"></i>
                </div>
                <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-yellow-500 bg-clip-text text-transparent">
                    نوع حساب
                </h1>
                <p class="text-gray-600 mt-2 text-sm">
                    نوعی را انتخاب کنید که بهترین‌تر شما را توصیف کند
                </p>

                
                <div class="flex items-center justify-center gap-2 mt-6">
                    <div class="w-8 h-8 rounded-full bg-gray-400 text-white flex items-center justify-center text-xs font-bold">✓</div>
                    <div class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center text-xs font-bold">2</div>
                    <div class="w-8 h-8 border-2 border-gray-400 rounded-full flex items-center justify-center text-xs font-bold text-gray-400">3</div>
                </div>
            </div>

            
            <form method="POST" action="<?php echo e(route('register.type.store')); ?>" class="space-y-4">
                <?php echo csrf_field(); ?>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    
                    <label class="relative group cursor-pointer">
                        <input type="radio" name="type" value="company" class="hidden peer" required>
                        <div class="backdrop-blur-sm bg-white/50 border-2 border-white/60 hover:border-blue-500 hover:bg-blue-50/50 rounded-2xl p-6 transition-all peer-checked:border-blue-600 peer-checked:bg-blue-100/40 peer-checked:ring-2 peer-checked:ring-blue-500">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-600 to-blue-500 flex items-center justify-center text-white text-xl flex-shrink-0">
                                    <i class="fa-solid fa-building"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-800">شرکت آسانسوری</h3>
                                    <p class="text-xs text-gray-600">خدمات و نصب</p>
                                </div>
                            </div>
                            <div class="absolute top-3 right-3 w-5 h-5 rounded-full border-2 border-white/60 bg-white/50 peer-checked:bg-blue-600 peer-checked:border-blue-600 peer-checked:flex peer-checked:items-center peer-checked:justify-center hidden transition-all">
                                <i class="fa-solid fa-check text-white text-xs"></i>
                            </div>
                        </div>
                    </label>

                    
                    <label class="relative group cursor-pointer">
                        <input type="radio" name="type" value="manufacturer" class="hidden peer" required>
                        <div class="backdrop-blur-sm bg-white/50 border-2 border-white/60 hover:border-yellow-500 hover:bg-yellow-50/50 rounded-2xl p-6 transition-all peer-checked:border-yellow-600 peer-checked:bg-yellow-100/40 peer-checked:ring-2 peer-checked:ring-yellow-500">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-yellow-500 to-orange-500 flex items-center justify-center text-white text-xl flex-shrink-0">
                                    <i class="fa-solid fa-industry"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-800">تولیدکننده</h3>
                                    <p class="text-xs text-gray-600">تولید و تامین</p>
                                </div>
                            </div>
                            <div class="absolute top-3 right-3 w-5 h-5 rounded-full border-2 border-white/60 bg-white/50 peer-checked:bg-yellow-600 peer-checked:border-yellow-600 peer-checked:flex peer-checked:items-center peer-checked:justify-center hidden transition-all">
                                <i class="fa-solid fa-check text-white text-xs"></i>
                            </div>
                        </div>
                    </label>

                    
                    <label class="relative group cursor-pointer">
                        <input type="radio" name="type" value="store" class="hidden peer" required>
                        <div class="backdrop-blur-sm bg-white/50 border-2 border-white/60 hover:border-green-500 hover:bg-green-50/50 rounded-2xl p-6 transition-all peer-checked:border-green-600 peer-checked:bg-green-100/40 peer-checked:ring-2 peer-checked:ring-green-500">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-green-600 to-green-500 flex items-center justify-center text-white text-xl flex-shrink-0">
                                    <i class="fa-solid fa-shop"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-800">فروشگاه</h3>
                                    <p class="text-xs text-gray-600">فروش قطعات</p>
                                </div>
                            </div>
                            <div class="absolute top-3 right-3 w-5 h-5 rounded-full border-2 border-white/60 bg-white/50 peer-checked:bg-green-600 peer-checked:border-green-600 peer-checked:flex peer-checked:items-center peer-checked:justify-center hidden transition-all">
                                <i class="fa-solid fa-check text-white text-xs"></i>
                            </div>
                        </div>
                    </label>

                    
                    <label class="relative group cursor-pointer">
                        <input type="radio" name="type" value="technician" class="hidden peer" required>
                        <div class="backdrop-blur-sm bg-white/50 border-2 border-white/60 hover:border-purple-500 hover:bg-purple-50/50 rounded-2xl p-6 transition-all peer-checked:border-purple-600 peer-checked:bg-purple-100/40 peer-checked:ring-2 peer-checked:ring-purple-500">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-purple-600 to-purple-500 flex items-center justify-center text-white text-xl flex-shrink-0">
                                    <i class="fa-solid fa-wrench"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-800">تکنسین</h3>
                                    <p class="text-xs text-gray-600">خدمات تعمیر</p>
                                </div>
                            </div>
                            <div class="absolute top-3 right-3 w-5 h-5 rounded-full border-2 border-white/60 bg-white/50 peer-checked:bg-purple-600 peer-checked:border-purple-600 peer-checked:flex peer-checked:items-center peer-checked:justify-center hidden transition-all">
                                <i class="fa-solid fa-check text-white text-xs"></i>
                            </div>
                        </div>
                    </label>

                    
                    <label class="relative group cursor-pointer">
                        <input type="radio" name="type" value="employer" class="hidden peer" required>
                        <div class="backdrop-blur-sm bg-white/50 border-2 border-white/60 hover:border-pink-500 hover:bg-pink-50/50 rounded-2xl p-6 transition-all peer-checked:border-pink-600 peer-checked:bg-pink-100/40 peer-checked:ring-2 peer-checked:ring-pink-500">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-pink-600 to-pink-500 flex items-center justify-center text-white text-xl flex-shrink-0">
                                    <i class="fa-solid fa-briefcase"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-800">کارفرما</h3>
                                    <p class="text-xs text-gray-600">درخواست خدمات</p>
                                </div>
                            </div>
                            <div class="absolute top-3 right-3 w-5 h-5 rounded-full border-2 border-white/60 bg-white/50 peer-checked:bg-pink-600 peer-checked:border-pink-600 peer-checked:flex peer-checked:items-center peer-checked:justify-center hidden transition-all">
                                <i class="fa-solid fa-check text-white text-xs"></i>
                            </div>
                        </div>
                    </label>
                </div>

                
                <button
                    type="submit"
                    class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-yellow-600 text-white font-bold py-3.5 rounded-2xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg active:scale-95 flex items-center justify-center gap-2 mt-8"
                >
                    <span>مرحلهٔ بعد</span>
                    <i class="fa-solid fa-arrow-left"></i>
                </button>

                
                <div class="text-center">
                    <a href="<?php echo e(route('login')); ?>" class="text-sm text-blue-600 hover:text-yellow-500 font-semibold transition">
                        بازگشت
                    </a>
                </div>
            </form>

        </div>
    </div>
</div>

<style>
input[type="radio"]:checked + div {
    animation: slideIn 0.3s ease;
}

@keyframes slideIn {
    from {
        transform: scale(0.95);
        opacity: 0;
    }
    to {
        transform: scale(1);
        opacity: 1;
    }
}
</style>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\AsansorPRO\marketplace\resources\views/auth/register-type.blade.php ENDPATH**/ ?>