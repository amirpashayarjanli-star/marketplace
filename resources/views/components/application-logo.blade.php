{{--
    لوگوی برند — جایگزین لوگوی پیش‌فرض لاراول.

    این کامپوننت در layouts/guest (صفحه‌های بازیابی رمز و تایید ایمیل) و
    layouts/navigation استفاده می‌شود. قبلاً SVG لاراول بود و به کاربر
    نشان داده می‌شد.

    کلاس‌های fill-current / text-gray-* که از قالب قدیمی به این کامپوننت
    پاس داده می‌شوند روی <img> بی‌اثرند، پس ابعاد را خودمان می‌دهیم.
--}}

<img
    src="{{ asset('images/logo/logo.png') }}"
    alt="{{ config('app.name') }}"
    {{ $attributes->merge(['class' => 'h-14 w-auto']) }}>
