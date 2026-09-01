<?php

namespace App\Filament\Admin\Resources\Customers\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

/*
| مشتری از الگوی مشترک پروفایل‌ها استفاده نمی‌کند: پروفایلش هیچ‌وقت در
| دایرکتوری دیده نمی‌شود، پس نه is_active دارد نه امتیاز و نه معرفی.
*/
class CustomerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                TextInput::make('name')
                    ->label('نام')
                    ->required()
                    ->maxLength(255),

                TextInput::make('mobile')
                    ->label('موبایل')
                    ->tel()
                    ->maxLength(20),

                TextInput::make('phone')
                    ->label('تلفن ثابت')
                    ->tel()
                    ->maxLength(30),

                TextInput::make('province')
                    ->label('استان')
                    ->maxLength(100),

                TextInput::make('city')
                    ->label('شهر')
                    ->maxLength(100),

                Select::make('dedicated_technician_id')
                    ->label('تکنسین ثابت')
                    ->relationship('dedicatedTechnician', 'name')
                    ->searchable()
                    ->preload()
                    ->helperText('هر خرابی جدید پیش‌فرض به این تکنسین می‌رود.'),

                Textarea::make('address')
                    ->label('آدرس')
                    ->rows(2)
                    ->columnSpanFull(),

            ]);
    }
}
