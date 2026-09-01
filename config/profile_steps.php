<?php

/*
|--------------------------------------------------------------------------
| مراحل تکمیل پروفایل
|--------------------------------------------------------------------------
|
| تنها منبع حقیقت برای اینکه هر نوع حساب چه فیلدهایی باید پر کنه.
| هم فرم داشبورد، هم اعتبارسنجی، هم درصد تکمیل از همین‌جا خونده میشن،
| پس هیچ‌وقت از هم جدا نمی‌افتن.
|
| type: text | tel | email | url | number | textarea | province | image | tags
| هر فیلدی که اینجا باشه اجباریه، مگر 'optional' => true.
|
*/

$contact = [

    'mobile' => [
        'label' => 'شماره موبایل',
        'type'  => 'tel',
        'rules' => 'required|regex:/^09[0-9]{9}$/',
        'hint'  => 'مثال: 09121234567',
    ],

    'phone' => [
        'label' => 'تلفن ثابت',
        'type'  => 'tel',
        'rules' => 'required|regex:/^0[0-9]{2,3}[0-9]{7,8}$/',
        'hint'  => 'با کد شهر، مثال: 02112345678',
    ],

    'email' => [
        'label' => 'ایمیل',
        'type'  => 'email',
        'rules' => 'required|email|max:255',
    ],

];


$website = [

    'website' => [
        'label'    => 'وب‌سایت',
        'type'     => 'url',
        'rules'    => 'nullable|url|max:255',
        'optional' => true,
        'hint'     => 'اگر ندارید خالی بگذارید',
    ],

];


$location = [

    'province' => [
        'label' => 'استان',
        'type'  => 'province',
        'rules' => 'required|string|max:100',
    ],

    'city' => [
        'label' => 'شهر',
        'type'  => 'text',
        'rules' => 'required|string|max:100',
    ],

    'address' => [
        'label' => 'نشانی کامل',
        'type'  => 'textarea',
        'rules' => 'required|string|min:10|max:500',
        'hint'  => 'خیابان، کوچه، پلاک',
    ],

];


$businessIdentity = function (string $noun) {

    return [

        'name' => [
            'label' => 'نام ' . $noun,
            'type'  => 'text',
            'rules' => 'required|string|min:3|max:255',
        ],

        'manager_name' => [
            'label' => 'نام مدیر',
            'type'  => 'text',
            'rules' => 'required|string|min:3|max:255',
        ],

        'experience' => [
            'label' => 'سابقه فعالیت (سال)',
            'type'  => 'number',
            'rules' => 'required|integer|min:0|max:100',
        ],

    ];

};


$businessMedia = [

    'logo' => [
        'label' => 'لوگو',
        'type'  => 'image',
        'rules' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        'hint'  => 'حداکثر ۲ مگابایت',
    ],

    'cover' => [
        'label' => 'تصویر کاور',
        'type'  => 'image',
        'rules' => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
        'hint'  => 'تصویر بالای صفحه پروفایل، حداکثر ۴ مگابایت',
    ],

    'description' => [
        'label' => 'معرفی',
        'type'  => 'textarea',
        'rules' => 'required|string|min:50|max:2000',
        'hint'  => 'حداقل ۵۰ حرف',
    ],

];


$businessProfile = function (string $noun) use ($businessIdentity, $contact, $website, $location, $businessMedia) {

    return [

        'identity' => [
            'title'  => 'اطلاعات پایه',
            'fields' => $businessIdentity($noun),
        ],

        'contact' => [
            'title'  => 'راه‌های ارتباطی',
            'fields' => $contact + $website,
        ],

        'location' => [
            'title'  => 'موقعیت مکانی',
            'fields' => $location,
        ],

        'presentation' => [
            'title'  => 'معرفی و تصاویر',
            'fields' => $businessMedia,
        ],

    ];

};


return [

    'company' => [
        'label'    => 'شرکت آسانسوری',
        'relation' => 'company',
        'model'    => App\Models\Company::class,
        'steps'    => $businessProfile('شرکت'),
    ],


    'manufacturer' => [
        'label'    => 'تولیدکننده',
        'relation' => 'manufacturer',
        'model'    => App\Models\Manufacturer::class,
        'steps'    => $businessProfile('مجموعه'),
    ],


    'store' => [
        'label'    => 'فروشگاه',
        'relation' => 'store',
        'model'    => App\Models\Store::class,
        'steps'    => $businessProfile('فروشگاه'),
    ],


    'technician' => [

        'label'    => 'تکنسین',
        'relation' => 'technician',
        'model'    => App\Models\Technician::class,

        'steps' => [

            'identity' => [
                'title'  => 'اطلاعات فردی',
                'fields' => [

                    'name' => [
                        'label' => 'نام و نام خانوادگی',
                        'type'  => 'text',
                        'rules' => 'required|string|min:3|max:255',
                    ],

                    'experience' => [
                        'label' => 'سابقه کار (سال)',
                        'type'  => 'number',
                        'rules' => 'required|integer|min:0|max:100',
                    ],

                ],
            ],


            'skills' => [
                'title'  => 'تخصص‌ها',
                'fields' => [

                    'skills' => [
                        'label' => 'مهارت‌ها و تخصص‌ها',
                        'type'  => 'tags',
                        'rules' => 'required|string|min:3|max:500',
                        'hint'  => 'هر تخصص را با ویرگول جدا کنید. مثال: نصب آسانسور، سرویس و نگهداری، تعمیر تابلو',
                    ],

                ],
            ],


            'contact' => [
                'title'  => 'راه‌های ارتباطی',
                'fields' => [
                    'mobile' => $contact['mobile'],
                    'phone'  => $contact['phone'],
                ],
            ],


            'location' => [
                'title'  => 'موقعیت مکانی',
                'fields' => $location,
            ],


            'presentation' => [
                'title'  => 'معرفی و تصویر',
                'fields' => [

                    'avatar' => [
                        'label' => 'عکس پرسنلی',
                        'type'  => 'image',
                        'rules' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
                        'hint'  => 'حداکثر ۲ مگابایت',
                    ],

                    'description' => [
                        'label' => 'معرفی خودتان',
                        'type'  => 'textarea',
                        'rules' => 'required|string|min:50|max:2000',
                        'hint'  => 'حداقل ۵۰ حرف',
                    ],

                ],
            ],

        ],
    ],


    'employer' => [

        'label'    => 'کارفرما',
        'relation' => 'employer',
        'model'    => App\Models\Employer::class,

        'steps' => [

            'identity' => [
                'title'  => 'اطلاعات پایه',
                'fields' => [

                    'name' => [
                        'label' => 'نام / نام مجموعه',
                        'type'  => 'text',
                        'rules' => 'required|string|min:3|max:255',
                    ],

                ],
            ],


            'contact' => [
                'title'  => 'راه‌های ارتباطی',
                'fields' => $contact,
            ],


            'location' => [
                'title'  => 'موقعیت مکانی',
                'fields' => $location,
            ],


            'presentation' => [
                'title'  => 'معرفی',
                'fields' => [

                    'description' => [
                        'label' => 'معرفی',
                        'type'  => 'textarea',
                        'rules' => 'required|string|min:30|max:2000',
                        'hint'  => 'حداقل ۳۰ حرف',
                    ],

                ],
            ],

        ],
    ],

];
