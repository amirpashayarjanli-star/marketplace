// Global phone input validation
document.addEventListener('DOMContentLoaded', function() {
    // Find all phone/mobile input fields
    const phoneInputs = document.querySelectorAll(
        'input[type="tel"], ' +
        'input[name="phone"], ' +
        'input[name="mobile"]'
    );

    phoneInputs.forEach(input => {
        // Prevent invalid characters from being typed
        input.addEventListener('keypress', function(e) {
            const char = String.fromCharCode(e.which);
            // Only allow digits, space, dash, plus, and parentheses
            if (!/[0-9\s\-\+\(\)]/.test(char)) {
                e.preventDefault();
            }
        });

        // Remove invalid characters on input
        input.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9\s\-\+\(\)]/g, '');
        });

        // Prevent paste of invalid characters
        input.addEventListener('paste', function(e) {
            e.preventDefault();
            const pastedText = (e.clipboardData || window.clipboardData).getData('text');
            const cleanedText = pastedText.replace(/[^0-9\s\-\+\(\)]/g, '');
            this.value = cleanedText;
        });

        // Mobile keyboard on mobile devices
        if (input.hasAttribute('inputmode') || input.type === 'tel') {
            input.setAttribute('inputmode', 'numeric');
        }
    });
});
