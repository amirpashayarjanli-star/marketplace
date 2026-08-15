


<?php $__env->startSection('content'); ?>


<h1 class="text-3xl font-bold mb-6">

داشبورد فروشگاه

</h1>







<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">





<div class="bg-white rounded-2xl shadow p-6">


<div class="text-gray-500 mb-3">

محصولات ثبت شده

</div>


<div class="text-4xl font-bold">

<?php echo e($products ?? 0); ?>


</div>


</div>








<div class="bg-white rounded-2xl shadow p-6">


<div class="text-gray-500 mb-3">

نظرات مشتریان

</div>


<div class="text-4xl font-bold">

<?php echo e($reviews ?? 0); ?>


</div>


</div>








<div class="bg-white rounded-2xl shadow p-6">


<div class="text-gray-500 mb-3">

امتیاز فروشگاه

</div>


<div class="text-4xl font-bold">

<?php echo e($store->rating ?? 0); ?>


⭐

</div>


</div>








<div class="bg-white rounded-2xl shadow p-6">


<div class="text-gray-500 mb-3">

سابقه فعالیت

</div>


<div class="text-4xl font-bold">

<?php echo e($store->experience ?? 0); ?>


سال

</div>


</div>






</div>









<div class="bg-white rounded-2xl shadow p-6 mt-8">


<h2 class="text-xl font-bold mb-5">

اطلاعات فروشگاه

</h2>





<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($store): ?>



<div class="space-y-3">



<p>

<strong>
نام فروشگاه:
</strong>

<?php echo e($store->name); ?>


</p>





<p>

<strong>
مدیر:
</strong>

<?php echo e($store->manager_name ?? 'ثبت نشده'); ?>


</p>





<p>

<strong>
شهر:
</strong>

<?php echo e($store->city ?? 'ثبت نشده'); ?>


</p>





<p>

<strong>
توضیحات:
</strong>

<?php echo e($store->description ?? 'ثبت نشده'); ?>


</p>



</div>




<?php else: ?>


<p class="text-gray-500">

اطلاعات فروشگاه ثبت نشده است.

</p>


<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>



</div>









<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">





<div class="bg-white rounded-2xl shadow p-6">


<h2 class="text-xl font-bold mb-5">

آخرین محصولات

</h2>



<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(($products ?? 0) > 0): ?>


<p class="text-green-600">

<?php echo e($products); ?> محصول ثبت شده دارید.

</p>


<?php else: ?>


<p class="text-gray-500">

هنوز محصولی ثبت نشده است.

</p>


<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>



</div>








<div class="bg-white rounded-2xl shadow p-6">


<h2 class="text-xl فوق-bold mb-5">

درخواست‌ها

</h2>


<p class="text-gray-500">

درخواست جدیدی وجود ندارد.

</p>



</div>






</div>






<?php $__env->stopSection(); ?>

<?php echo $__env->make('dashboard.layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\AsansorPRO\marketplace\resources\views/dashboard/store.blade.php ENDPATH**/ ?>