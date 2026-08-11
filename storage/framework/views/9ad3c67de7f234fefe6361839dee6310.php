<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'dollar' => [
        'price' => 0,
        'change' => 0,
        'date' => null,
    ]
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'dollar' => [
        'price' => 0,
        'change' => 0,
        'date' => null,
    ]
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>


<div class="hero-dollar-widget">


    <div class="dollar-live">
        <span></span>
        LIVE
    </div>


    <div class="dollar-title">
        USD
    </div>


    <div class="dollar-price">

        <?php echo e(number_format($dollar['price'] ?? 0)); ?>


        <small>
            ریال
        </small>

    </div>


    <div class="dollar-change
        <?php echo e(($dollar['change'] ?? 0) < 0 ? 'down' : 'up'); ?>">

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(($dollar['change'] ?? 0) < 0): ?>
            
        <?php else: ?>

        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php echo e(number_format(abs($dollar['change'] ?? 0))); ?>


    </div>


</div>
<?php /**PATH D:\AsansorPRO\marketplace\resources\views/components/hero-dollar.blade.php ENDPATH**/ ?>