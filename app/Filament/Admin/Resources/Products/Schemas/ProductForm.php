<?php

namespace App\Filament\Admin\Resources\Products\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                TextInput::make('name')
                    ->label('نام محصول')
                    ->required()
                    ->maxLength(255),

                TextInput::make('category')
                    ->label('دسته')
                    ->maxLength(255)
                    ->helperText('فعلاً متن آزاد است — جدول دسته‌بندی هنوز ستونی ندارد.'),

                Select::make('brand_id')
                    ->label('برند')
                    ->relationship('brand', 'name')
                    ->searchable()
                    ->preload(),

                Select::make('manufacturer_id')
                    ->label('تولیدکننده')
                    ->relationship('manufacturer', 'name')
                    ->searchable()
                    ->preload(),

                Select::make('store_id')
                    ->label('فروشگاه')
                    ->relationship('store', 'name')
                    ->searchable()
                    ->preload(),

                TextInput::make('image')
                    ->label('مسیر تصویر')
                    ->maxLength(255),

                Textarea::make('description')
                    ->label('توضیحات')
                    ->rows(3)
                    ->columnSpanFull(),

                Toggle::make('is_active')
                    ->label('نمایش در سایت'),

                Toggle::make('is_verified')
                    ->label('نشان تایید'),

            ]);
    }
}
