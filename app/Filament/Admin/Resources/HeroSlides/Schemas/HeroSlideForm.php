<?php

namespace App\Filament\Admin\Resources\HeroSlides\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class HeroSlideForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            FileUpload::make('image')
                ->label('تصویر اسلاید')
                ->image()
                ->imageEditor()
                ->directory('hero-slides')
                ->disk('public')
                ->maxSize(4096)
                ->required()
                ->helperText('نسبت پیشنهادی ۳ به ۴ (عمودی). حداکثر ۴ مگابایت.'),

            TextInput::make('title')
                ->label('عنوان')
                ->maxLength(120)
                ->helperText('روی تصویر نمایش داده می‌شود. خالی بگذارید تا عنوانی نیاید.'),

            TextInput::make('subtitle')
                ->label('زیرعنوان')
                ->maxLength(160),

            TextInput::make('button_label')
                ->label('متن دکمه')
                ->maxLength(40)
                ->helperText('اگر خالی باشد، دکمه‌ای روی اسلاید نمایش داده نمی‌شود.'),

            TextInput::make('button_url')
                ->label('مقصد دکمه')
                ->maxLength(255)
                ->helperText('نشانی کامل (https://…) یا مسیر داخلی مثل /companies'),

            TextInput::make('sort_order')
                ->label('ترتیب نمایش')
                ->numeric()
                ->default(0)
                ->helperText('عدد کوچک‌تر جلوتر نمایش داده می‌شود.'),

            Toggle::make('is_active')
                ->label('فعال')
                ->default(true),

        ]);
    }
}
