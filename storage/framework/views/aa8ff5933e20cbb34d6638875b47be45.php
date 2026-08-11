<?php $__env->startSection('content'); ?>


<div class="min-h-screen flex items-center justify-center bg-gray-100">


<div class="bg-white rounded-2xl shadow p-8 w-full max-w-md">


<h1 class="text-2xl font-bold text-center mb-4">

تایید شماره موبایل

</h1>


<p class="text-gray-500 text-center mb-6">

کد ارسال شده را وارد کنید

</p>



<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>

<div class="bg-red-100 text-red-700 p-3 rounded mb-4">

<?php echo e($errors->first()); ?>


</div>

<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>



<form method="POST" action="<?php echo e(route('register.otp')); ?>">

<?php echo csrf_field(); ?>


<input

name="code"

maxlength="5"

placeholder="12345"

class="w-full border rounded-xl p-3 text-center text-xl"

required

>



<button

class="w-full bg-blue-600 text-white rounded-xl py-3 mt-5"

>

تایید

</button>



</form>



</div>


</div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\AsansorPRO\marketplace\resources\views/auth/register-otp.blade.php ENDPATH**/ ?>