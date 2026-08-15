<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>
آسانسور پرو | داشبورد
</title>


<script src="https://cdn.tailwindcss.com"></script>


</head>


<body class="bg-gray-100">


<div class="min-h-screen flex">


    <?php echo $__env->make('dashboard.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


    <div class="flex-1">


        <?php echo $__env->make('dashboard.partials.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


        <main class="p-6">

            <?php echo $__env->yieldContent('content'); ?>

        </main>


    </div>


</div>


</body>

</html>
<?php /**PATH D:\AsansorPRO\marketplace\resources\views/dashboard/layouts/dashboard.blade.php ENDPATH**/ ?>