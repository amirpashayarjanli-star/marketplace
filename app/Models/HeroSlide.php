<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class HeroSlide extends Model
{
    protected $fillable = [
        'image',
        'title',
        'subtitle',
        'button_label',
        'button_url',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }


    /** اسلایدهای فعال، به ترتیبی که مدیر تعیین کرده */
    public function scopeVisible(Builder $q): Builder
    {
        return $q->where('is_active', true)
                 ->orderBy('sort_order')
                 ->orderBy('id');
    }


    /** دکمه فقط وقتی معنی داره که هم متن داشته باشه هم مقصد */
    public function hasButton(): bool
    {
        return filled($this->button_label) && filled($this->button_url);
    }
}
