<?php

namespace App\Traits;

use Illuminate\Support\Str;

/**
 * ساخت خودکار slug یکتا هنگام ایجاد رکورد.
 *
 * مدل‌هایی که عنوانشان در ستونی غیر از name است، ستون مبدأ را با
 * $slugSource اعلام می‌کنند — مثل Project که title دارد.
 */
trait HasSlug
{
    protected static function bootHasSlug(): void
    {
        static::creating(function ($model) {

            if (! empty($model->slug)) {
                return;
            }

            $source = property_exists($model, 'slugSource')
                ? $model->slugSource
                : 'name';

            $base = Str::slug($model->{$source} ?? '');

            /*
            | اگر عنوان خالی یا تماماً نویسه‌ای باشد که slug ازش چیزی
            | درنمیاد، به نام مدل برمی‌گردیم — قبلاً همیشه «user-» بود
            | که برای برند و پروژه بی‌معنی بود.
            */
            if ($base === '') {
                $base = Str::lower(class_basename($model)) . '-' . Str::lower(Str::random(8));
            }

            $slug   = $base;
            $suffix = 1;

            while (static::where('slug', $slug)->exists()) {
                $slug = $base . '-' . $suffix;
                $suffix++;
            }

            $model->slug = $slug;
        });
    }
}
