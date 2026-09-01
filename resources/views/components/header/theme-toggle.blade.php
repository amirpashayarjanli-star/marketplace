{{-- دکمه‌ی تعویض حالت روز/شب --}}

<button type="button"
        id="theme-toggle-btn"
        class="header-account-btn theme-toggle-btn"
        title="تغییر به حالت شب/روز"
        aria-label="تغییر به حالت شب/روز">

    {{-- آفتاب: فقط توی حالت روز دیده میشه --}}
    <svg class="theme-icon theme-icon-sun" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <circle cx="12" cy="12" r="4.5" />
        <path stroke-linecap="round" d="M12 2.5v2M12 19.5v2M4.2 4.2l1.4 1.4M18.4 18.4l1.4 1.4M2.5 12h2M19.5 12h2M4.2 19.8l1.4-1.4M18.4 5.6l1.4-1.4" />
    </svg>

    {{-- ماه: فقط توی حالت شب دیده میشه --}}
    <svg class="theme-icon theme-icon-moon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
        <path d="M20.5 14.5A8.5 8.5 0 0 1 9.5 3.5a.75.75 0 0 0-.94-.98A9.5 9.5 0 1 0 21.48 15.44a.75.75 0 0 0-.98-.94Z" />
    </svg>

</button>


<script>
    (function () {
        var btn = document.getElementById('theme-toggle-btn');
        if (!btn) return;

        btn.addEventListener('click', function () {
            var root = document.documentElement;
            var next = root.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
            root.setAttribute('data-theme', next);
            localStorage.setItem('theme', next);
        });
    })();
</script>
