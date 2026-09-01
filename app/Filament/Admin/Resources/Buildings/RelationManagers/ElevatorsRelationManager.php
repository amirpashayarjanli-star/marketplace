<?php

namespace App\Filament\Admin\Resources\Buildings\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

/*
| تعداد دستگاه‌ها روی قیمت قرارداد اثر دارد. عمداً از داخل پرونده
| ویرایش می‌شود تا قراردادهای فعال دست‌نخورده بمانند و تغییر از تمدید
| بعدی اعمال شود — همان قاعده‌ای که سمت مشتری هم هست.
*/
class ElevatorsRelationManager extends RelationManager
{
    protected static string $relationship = 'elevators';

    protected static ?string $title = 'دستگاه‌های آسانسور';


    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([

                TextInput::make('label')
                    ->label('نام دستگاه')
                    ->required()
                    ->maxLength(120),

                TextInput::make('brand')
                    ->label('برند')
                    ->maxLength(120),

                TextInput::make('capacity_kg')
                    ->label('ظرفیت (کیلوگرم)')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(10000),

                TextInput::make('stops')
                    ->label('تعداد توقف')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(200),

                TextInput::make('install_year')
                    ->label('سال نصب')
                    ->numeric()
                    ->minValue(1300)
                    ->maxValue(1500),

                TextInput::make('serial_no')
                    ->label('شماره سریال')
                    ->maxLength(120),

            ]);
    }


    public function table(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('label')
                    ->label('دستگاه'),

                TextColumn::make('brand')
                    ->label('برند')
                    ->placeholder('—'),

                TextColumn::make('capacity_kg')
                    ->label('ظرفیت')
                    ->placeholder('—')
                    ->suffix(' kg'),

                TextColumn::make('stops')
                    ->label('توقف')
                    ->placeholder('—'),

                TextColumn::make('install_year')
                    ->label('سال نصب')
                    ->placeholder('—'),

                TextColumn::make('serial_no')
                    ->label('سریال')
                    ->placeholder('—')
                    ->toggleable(isToggledHiddenByDefault: true),

            ])

            ->headerActions([
                CreateAction::make()->label('افزودن دستگاه'),
            ])

            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
