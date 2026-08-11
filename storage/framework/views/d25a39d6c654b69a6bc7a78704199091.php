<?php $__env->startSection('content'); ?>


<div class="min-h-screen flex items-center justify-center bg-gray-100">


<div class="bg-white rounded-2xl shadow p-8 w-full max-w-md">


<h1 class="text-2xl font-bold text-center mb-6">

ثبت نام

</h1>



<form method="POST" action="<?php echo e(route('register')); ?>">

<?php echo csrf_field(); ?>



<input

name="name"

placeholder="نام و نام خانوادگی"

class="w-full border rounded-xl p-3 mb-4"

required

>



<input

name="mobile"

placeholder="شماره موبایل"

class="w-full border rounded-xl p-3 mb-4"

required

>



<input

type="password"

name="password"

placeholder="رمز عبور"

class="w-full border rounded-xl p-3 mb-4"

required

>



<input

type="password"

name="password_confirmation"

placeholder="تکرار رمز عبور"

class="w-full border rounded-xl p-3 mb-5"

required

>




<button

class="w-full bg-blue-600 text-white rounded-xl py-3"

>

ادامه

</button>



</form>



</div>


</div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\AsansorPRO\marketplace\resources\views/auth/register.blade.php ENDPATH**/ ?>