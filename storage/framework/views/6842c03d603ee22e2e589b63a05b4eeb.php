<div class="directory-filter glass-card">

    <form method="GET" class="w-full space-y-3">

        
        <div class="directory-search">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input
                type="text"
                name="search"
                placeholder="جستجوی شرکت آسانسوری..."
                value="<?php echo e(request('search')); ?>">
        </div>

        
        <div class="directory-options">

            <select name="city" onchange="this.form.submit()">
                <option value="">انتخاب شهر</option>
                <option value="تهران" <?php echo e(request('city') === 'تهران' ? 'selected' : ''); ?>>تهران</option>
                <option value="قم" <?php echo e(request('city') === 'قم' ? 'selected' : ''); ?>>قم</option>
                <option value="اصفهان" <?php echo e(request('city') === 'اصفهان' ? 'selected' : ''); ?>>اصفهان</option>
                <option value="مشهد" <?php echo e(request('city') === 'مشهد' ? 'selected' : ''); ?>>مشهد</option>
                <option value="کرج" <?php echo e(request('city') === 'کرج' ? 'selected' : ''); ?>>کرج</option>
                <option value="تبریز" <?php echo e(request('city') === 'تبریز' ? 'selected' : ''); ?>>تبریز</option>
                <option value="شیراز" <?php echo e(request('city') === 'شیراز' ? 'selected' : ''); ?>>شیراز</option>
                <option value="کیش" <?php echo e(request('city') === 'کیش' ? 'selected' : ''); ?>>کیش</option>
                <option value="آنجا" <?php echo e(request('city') === 'آنجا' ? 'selected' : ''); ?>>آنجا</option>
            </select>

            <select name="sort" onchange="this.form.submit()">
                <option value="">مرتب سازی</option>
                <option value="rating" <?php echo e(request('sort') === 'rating' ? 'selected' : ''); ?>>بیشترین امتیاز</option>
                <option value="reviews" <?php echo e(request('sort') === 'reviews' ? 'selected' : ''); ?>>بیشترین نظر</option>
                <option value="newest" <?php echo e(request('sort') === 'newest' ? 'selected' : ''); ?>>جدیدترین</option>
            </select>
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            <i class="fa-solid fa-search ml-2"></i>جستجو
        </button>

    </form>

    
    <a href="#"
       class="register-company-btn block text-center mt-3">
        <i class="fa-solid fa-building"></i>
        <?php echo e($register ?? 'ثبت'); ?>

    </a>

</div>
<?php /**PATH D:\AsansorPRO\marketplace\resources\views/components/directory/filter-box.blade.php ENDPATH**/ ?>