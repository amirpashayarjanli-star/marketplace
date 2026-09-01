<?php

namespace App\Filament\Admin\Resources\Brands\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class BrandForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                TextInput::make('name')
                    ->label('نام برند')
                    ->required()
                    ->maxLength(255),

                TextInput::make('logo')
                    ->label('مسیر لوگو')
                    ->maxLength(255)
                    ->helperText('نشانی فایل لوگو، مثلاً images/brands/schindler.png'),

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
