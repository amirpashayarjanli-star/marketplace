<div class="review-form-card">

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session()->has('success')): ?>

        <div class="success-message">
            <?php echo e(session('success')); ?>

        </div>

    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


    <form wire:submit="submit">


        <div class="form-group">

            <input
                type="text"
                wire:model="name"
                placeholder="نام شما"
            >

        </div>



        <div class="form-group">

            <select wire:model="rating">

                <option value="5">★★★★★</option>
                <option value="4">★★★★</option>
                <option value="3">★★★</option>
                <option value="2">★★</option>
                <option value="1">★</option>

            </select>

        </div>



        <div class="form-group">

            <textarea
                wire:model="comment"
                placeholder="نظر خود را بنویسید"
            ></textarea>

        </div>



        <button type="submit">
            ارسال نظر
        </button>


    </form>

</div>
<?php /**PATH D:\AsansorPRO\marketplace\resources\views/livewire/review-form.blade.php ENDPATH**/ ?>