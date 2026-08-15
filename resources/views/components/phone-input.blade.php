@props([
    'name' => 'phone',
    'label' => 'شماره تماس',
    'placeholder' => '0211234567',
    'required' => false,
    'value' => '',
    'icon' => 'fa-phone',
    'error' => false,
])

<div class="relative group">
    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
        <i class="fa-solid {{ $icon }} text-blue-600 group-focus-within:text-yellow-500 transition"></i>
    </div>
    <input
        type="tel"
        name="{{ $name }}"
        value="{{ old($name, $value) }}"
        placeholder="{{ $placeholder }}"
        pattern="[0-9\s\-\+\(\)]{10,20}"
        inputmode="numeric"
        class="w-full bg-white/50 border border-white/60 rounded-2xl px-5 py-3.5 pr-12 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent backdrop-blur-sm transition-all {{ $error || $errors->has($name) ? 'ring-2 ring-red-500' : '' }}"
        {{ $required ? 'required' : '' }}
    >
    <label class="absolute -top-2.5 right-4 text-xs font-semibold bg-white/80 px-2 text-gray-700">
        {{ $label }}
    </label>
</div>

<script>
// Only allow numbers, spaces, dashes, plus, and parentheses
document.addEventListener('DOMContentLoaded', function() {
    const phoneInputs = document.querySelectorAll('input[type="tel"][pattern*="0-9"]');
    phoneInputs.forEach(input => {
        input.addEventListener('input', function(e) {
            // Remove any invalid characters
            this.value = this.value.replace(/[^0-9\s\-\+\(\)]/g, '');
        });

        input.addEventListener('keypress', function(e) {
            const char = String.fromCharCode(e.which);
            if (!/[0-9\s\-\+\(\)]/.test(char)) {
                e.preventDefault();
            }
        });
    });
});
</script>
