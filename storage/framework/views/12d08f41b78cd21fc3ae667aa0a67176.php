<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">


    <title>
        <?php echo $__env->yieldContent('title', 'آسانسور پرو'); ?>
    </title>


    <?php echo app('Illuminate\Foundation\Vite')([
        'resources/css/app.css',
        'resources/js/app.js'
    ]); ?>


</head>


<body>





    <main>

        <?php echo $__env->yieldContent('content'); ?>

    </main>


</body>

</html>
<?php /**PATH D:\AsansorPRO\marketplace\resources\views/layouts/app.blade.php ENDPATH**/ ?>