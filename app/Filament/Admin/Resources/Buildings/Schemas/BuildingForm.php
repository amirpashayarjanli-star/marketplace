<?php

namespace App\Filament\Admin\Resources\Buildings\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class BuildingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                TextInput::make('code')
                    ->label('شماره پرونده')
                    ->disabled()
                    ->dehydrated(false)
                    ->helperText('خودکار ساخته می‌شود و تغییر نمی‌کند.'),

                Select::make('customer_id')
                    ->label('مشتری')
                    ->relationship('customer', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                TextInput::make('title')
                    ->label('نام ساختمان')
                    ->required()
                    ->maxLength(150),

                TextInput::make('province')
                    ->label('استان')
                    ->maxLength(60),

                TextInput::make('city')
                    ->label('شهر')
                    ->maxLength(60),

                Textarea::make('address')
                    ->label('آدرس')
                    ->rows(2)
                    ->required()
                    ->maxLength(500)
                    ->columnSpanFull(),

                TextInput::make('postal_code')
                    ->label('کد پستی')
                    ->maxLength(20),

                TextInput::make('floors')
                    ->label('تعداد طبقات')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(200),

                TextInput::make('units')
                    ->label('تعداد واحدها')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(2000),

                TextInput::make('manager_name')
                    ->label('نام مدیر ساختمان')
                    ->maxLength(120),

                TextInput::make('manager_mobile')
                    ->label('موبایل مدیر ساختمان')
                    ->tel()
                    ->maxLength(20),

                Textarea::make('notes')
                    ->label('توضیحات')
                    ->rows(3)
                    ->maxLength(1000)
                    ->columnSpanFull(),

            ]);
    }
}
