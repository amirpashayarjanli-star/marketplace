<?php $__env->startSection('content'); ?>

<div class="min-h-screen flex items-center justify-center bg-gray-100 py-10">

    <div class="w-full max-w-md bg-white rounded-2xl shadow p-8">


        <div class="text-center mb-8">

            <h1 class="text-2xl font-bold">
                ورود به حساب کاربری
            </h1>

            <p class="text-gray-500 mt-2">
                برای ورود شماره موبایل خود را وارد کنید
            </p>

        </div>



        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>

            <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4">

                <?php echo e($errors->first()); ?>


            </div>

        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>



        <form method="POST" action="<?php echo e(route('login')); ?>">

            <?php echo csrf_field(); ?>



            <div class="mb-4">

                <label class="block mb-2">
                    شماره موبایل
                </label>


                <input

                    type="text"

                    name="mobile"

                    value="<?php echo e(old('mobile')); ?>"

                    placeholder="09123456789"

                    class="w-full border rounded-xl px-4 py-3"

                    required

                >

            </div>



            <div class="mb-6">

                <label class="block mb-2">
                    رمز عبور
                </label>


                <input

                    type="password"

                    name="password"

                    placeholder="رمز عبور"

                    class="w-full border rounded-xl px-4 py-3"

                    required

                >

            </div>



            <button

                type="submit"

                class="w-full bg-blue-600 text-white rounded-xl py-3"

            >

                مرحله بعد

            </button>


        </form>




        <div class="text-center mt-6 text-gray-600">


            آیا حساب کاربری ندارید؟

            <a

                href="<?php echo e(route('register')); ?>"

                class="text-blue-600 font-bold"

            >

                ثبت نام

            </a>


        </div>



    </div>

</div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\AsansorPRO\marketplace\resources\views/auth/login.blade.php ENDPATH**/ ?>