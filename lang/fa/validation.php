<?php

/*
|--------------------------------------------------------------------------
| پیام‌های اعتبارسنجی — فارسی
|--------------------------------------------------------------------------
|
| بدون این فایل، لاراول پیام‌های پیش‌فرض انگلیسی را نشان می‌داد و روی
| سایت کاملاً فارسی، خطاهایی مثل «The لوگو failed to upload.» به کاربر
| نمایش داده می‌شد (ترکیب انگلیسی و فارسی).
|
*/

return [

    'accepted' => ':attribute باید پذیرفته شود.',
    'active_url' => ':attribute یک آدرس معتبر نیست.',
    'after' => ':attribute باید تاریخی بعد از :date باشد.',
    'after_or_equal' => ':attribute باید تاریخی بعد از :date یا برابر با آن باشد.',
    'alpha' => ':attribute باید فقط شامل حروف باشد.',
    'alpha_dash' => ':attribute باید فقط شامل حروف، اعداد، خط تیره و زیرخط باشد.',
    'alpha_num' => ':attribute باید فقط شامل حروف و اعداد باشد.',
    'array' => ':attribute باید یک آرایه باشد.',
    'before' => ':attribute باید تاریخی قبل از :date باشد.',
    'before_or_equal' => ':attribute باید تاریخی قبل از :date یا برابر با آن باشد.',

    'between' => [
        'array' => ':attribute باید بین :min تا :max مورد باشد.',
        'file' => 'حجم :attribute باید بین :min تا :max کیلوبایت باشد.',
        'numeric' => ':attribute باید بین :min تا :max باشد.',
        'string' => ':attribute باید بین :min تا :max کاراکتر باشد.',
    ],

    'boolean' => ':attribute فقط می‌تواند بله یا خیر باشد.',
    'confirmed' => 'تکرار :attribute با مقدار واردشده یکسان نیست.',
    'current_password' => 'رمز عبور واردشده صحیح نیست.',
    'date' => ':attribute یک تاریخ معتبر نیست.',
    'date_equals' => ':attribute باید برابر با تاریخ :date باشد.',
    'date_format' => 'قالب :attribute با :format مطابقت ندارد.',
    'declined' => ':attribute باید رد شود.',
    'different' => ':attribute و :other باید متفاوت باشند.',
    'digits' => ':attribute باید :digits رقم باشد.',
    'digits_between' => ':attribute باید بین :min تا :max رقم باشد.',
    'dimensions' => 'ابعاد تصویر :attribute مجاز نیست.',
    'distinct' => 'مقدار :attribute تکراری است.',
    'email' => ':attribute باید یک ایمیل معتبر باشد.',
    'ends_with' => ':attribute باید با یکی از این موارد پایان یابد: :values',
    'exists' => ':attribute انتخاب‌شده معتبر نیست.',
    'file' => ':attribute باید یک فایل باشد.',
    'filled' => ':attribute نمی‌تواند خالی باشد.',

    'gt' => [
        'array' => ':attribute باید بیشتر از :value مورد باشد.',
        'file' => 'حجم :attribute باید بیشتر از :value کیلوبایت باشد.',
        'numeric' => ':attribute باید بزرگ‌تر از :value باشد.',
        'string' => ':attribute باید بیشتر از :value کاراکتر باشد.',
    ],

    'gte' => [
        'array' => ':attribute باید :value مورد یا بیشتر باشد.',
        'file' => 'حجم :attribute باید حداقل :value کیلوبایت باشد.',
        'numeric' => ':attribute باید بزرگ‌تر یا مساوی :value باشد.',
        'string' => ':attribute باید حداقل :value کاراکتر باشد.',
    ],

    'image' => ':attribute باید یک تصویر باشد.',
    'in' => ':attribute انتخاب‌شده معتبر نیست.',
    'in_array' => ':attribute در :other وجود ندارد.',
    'integer' => ':attribute باید یک عدد صحیح باشد.',
    'ip' => ':attribute باید یک آدرس IP معتبر باشد.',
    'ipv4' => ':attribute باید یک آدرس IPv4 معتبر باشد.',
    'ipv6' => ':attribute باید یک آدرس IPv6 معتبر باشد.',
    'json' => ':attribute باید یک رشته‌ی JSON معتبر باشد.',

    'lt' => [
        'array' => ':attribute باید کمتر از :value مورد باشد.',
        'file' => 'حجم :attribute باید کمتر از :value کیلوبایت باشد.',
        'numeric' => ':attribute باید کوچک‌تر از :value باشد.',
        'string' => ':attribute باید کمتر از :value کاراکتر باشد.',
    ],

    'lte' => [
        'array' => ':attribute نباید بیشتر از :value مورد باشد.',
        'file' => 'حجم :attribute نباید بیشتر از :value کیلوبایت باشد.',
        'numeric' => ':attribute باید کوچک‌تر یا مساوی :value باشد.',
        'string' => ':attribute نباید بیشتر از :value کاراکتر باشد.',
    ],

    'max' => [
        'array' => ':attribute نباید بیشتر از :max مورد باشد.',
        'file' => 'حجم :attribute نباید بیشتر از :max کیلوبایت باشد.',
        'numeric' => ':attribute نباید بزرگ‌تر از :max باشد.',
        'string' => ':attribute نباید بیشتر از :max کاراکتر باشد.',
    ],

    'mimes' => ':attribute باید یکی از این فرمت‌ها باشد: :values',
    'mimetypes' => ':attribute باید یکی از این فرمت‌ها باشد: :values',

    'min' => [
        'array' => ':attribute باید حداقل :min مورد باشد.',
        'file' => 'حجم :attribute باید حداقل :min کیلوبایت باشد.',
        'numeric' => ':attribute نباید کوچک‌تر از :min باشد.',
        'string' => ':attribute باید حداقل :min کاراکتر باشد.',
    ],

    'multiple_of' => ':attribute باید مضربی از :value باشد.',
    'not_in' => ':attribute انتخاب‌شده معتبر نیست.',
    'not_regex' => 'قالب :attribute معتبر نیست.',
    'numeric' => ':attribute باید یک عدد باشد.',
    'password' => 'رمز عبور صحیح نیست.',
    'present' => ':attribute باید وجود داشته باشد.',
    'prohibited' => ':attribute مجاز نیست.',
    'prohibited_if' => 'وقتی :other برابر :value است، :attribute مجاز نیست.',
    'prohibited_unless' => 'مگر اینکه :other یکی از :values باشد، :attribute مجاز نیست.',
    'regex' => 'قالب :attribute معتبر نیست.',
    'required' => 'وارد کردن :attribute الزامی است.',
    'required_array_keys' => ':attribute باید شامل موارد زیر باشد: :values',
    'required_if' => 'وقتی :other برابر :value است، وارد کردن :attribute الزامی است.',
    'required_unless' => 'مگر اینکه :other یکی از :values باشد، وارد کردن :attribute الزامی است.',
    'required_with' => 'وقتی :values وارد شده، :attribute هم الزامی است.',
    'required_with_all' => 'وقتی :values وارد شده‌اند، :attribute هم الزامی است.',
    'required_without' => 'وقتی :values وارد نشده، :attribute الزامی است.',
    'required_without_all' => 'وقتی هیچ‌کدام از :values وارد نشده‌اند، :attribute الزامی است.',
    'same' => ':attribute و :other باید یکسان باشند.',

    'size' => [
        'array' => ':attribute باید دقیقاً :size مورد باشد.',
        'file' => 'حجم :attribute باید :size کیلوبایت باشد.',
        'numeric' => ':attribute باید برابر :size باشد.',
        'string' => ':attribute باید :size کاراکتر باشد.',
    ],

    'starts_with' => ':attribute باید با یکی از این موارد شروع شود: :values',
    'string' => ':attribute باید یک متن باشد.',
    'timezone' => ':attribute باید یک منطقه‌ی زمانی معتبر باشد.',
    'unique' => 'این :attribute قبلاً ثبت شده است.',
    'uploaded' => 'بارگذاری :attribute انجام نشد. حجم فایل را کمتر کنید و دوباره تلاش کنید.',
    'url' => ':attribute باید یک آدرس اینترنتی معتبر باشد.',
    'uuid' => ':attribute باید یک UUID معتبر باشد.',

    'custom' => [
        'mobile' => [
            'required' => 'شماره موبایل الزامی است.',
            'regex' => 'شماره موبایل صحیح نیست.',
            'unique' => 'این شماره موبایل قبلاً ثبت شده است.',
        ],
        'password' => [
            'required' => 'رمز عبور الزامی است.',
            'confirmed' => 'تکرار رمز عبور با رمز عبور یکسان نیست.',
            'min' => 'رمز عبور باید حداقل :min کاراکتر باشد.',
        ],
        'terms' => [
            'required' => 'پذیرش شرایط و ضوابط الزامی است.',
            'accepted' => 'پذیرش شرایط و ضوابط الزامی است.',
        ],
        'code' => [
            'required' => 'کد تایید الزامی است.',
            'digits' => 'کد تایید باید :digits رقم باشد.',
        ],
    ],

    'attributes' => [
        'mobile' => 'شماره موبایل',
        'password' => 'رمز عبور',
        'password_confirmation' => 'تکرار رمز عبور',
        'code' => 'کد تایید',
        'terms' => 'شرایط و ضوابط',
        'name' => 'نام',
        'email' => 'ایمیل',
        'phone' => 'تلفن',
        'website' => 'وب‌سایت',
        'province' => 'استان',
        'city' => 'شهر',
        'address' => 'آدرس',
        'description' => 'توضیحات',
        'logo' => 'لوگو',
        'cover' => 'تصویر کاور',
        'type' => 'نوع حساب',
    ],

];
