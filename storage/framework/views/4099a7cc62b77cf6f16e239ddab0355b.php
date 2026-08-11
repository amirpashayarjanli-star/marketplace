<?php $__env->startSection('content'); ?>


<div class="min-h-screen flex items-center justify-center bg-gray-100">


<div class="bg-white rounded-2xl shadow p-8 w-full max-w-lg">


<h1 class="text-2xl font-bold text-center mb-3">

نوع حساب خود را انتخاب کنید

</h1>


<p class="text-gray-500 text-center mb-8">

برای تکمیل ثبت نام، نوع فعالیت خود را مشخص کنید

</p>



<form method="POST" action="<?php echo e(route('register.type')); ?>">

<?php echo csrf_field(); ?>



<div class="grid grid-cols-1 gap-4">



<label class="border rounded-xl p-4 cursor-pointer hover:bg-gray-50">

<input
type="radio"
name="type"
value="company"
required
>

<span class="mr-2">
شرکت آسانسوری
</span>

</label>



<label class="border rounded-xl p-4 cursor-pointer hover:bg-gray-50">

<input
type="radio"
name="type"
value="manufacturer"
>

<span class="mr-2">
تولیدکننده
</span>

</label>




<label class="border rounded-xl p-4 cursor-pointer hover:bg-gray-50">

<input
type="radio"
name="type"
value="store"
>

<span class="mr-2">
فروشگاه
</span>

</label>




<label class="border rounded-xl p-4 cursor-pointer hover:bg-gray-50">

<input
type="radio"
name="type"
value="technician"
>

<span class="mr-2">
تکنسین
</span>

</label>




<label class="border rounded-xl p-4 cursor-pointer hover:bg-gray-50">

<input
type="radio"
name="type"
value="employer"
>

<span class="mr-2">
کارفرما / مالک پروژه
</span>

</label>



</div>




<button

class="w-full bg-blue-600 text-white rounded-xl py-3 mt-8"

>

ادامه

</button>



</form>



</div>


</div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\AsansorPRO\marketplace\resources\views/auth/register-type.blade.php ENDPATH**/ ?>