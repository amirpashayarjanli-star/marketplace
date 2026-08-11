<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasSlug
{
    protected static function bootHasSlug(): void
    {
        static::creating(function ($model) {

            if (!empty($model->slug)) {
                return;
            }

            $base = Str::slug($model->name ?? '');

            if ($base === '') {
                $base = 'user-' . Str::lower(Str::random(8));
            }

            $slug = $base;
            $suffix = 1;

            while (static::where('slug', $slug)->exists()) {
                $slug = $base . '-' . $suffix;
                $suffix++;
            }

            $model->slug = $slug;
        });
    }
}
