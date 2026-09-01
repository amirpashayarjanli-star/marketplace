<?php

namespace App\Filament\Admin\Resources\Projects\Schemas;

use App\Models\Project;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('پروژه')
                    ->schema([

                        TextInput::make('title')
                            ->label('عنوان')
                            ->required()
                            ->maxLength(255),

                        Select::make('type')
                            ->label('نوع کار')
                            ->options(Project::TYPES),

                        Select::make('status')
                            ->label('وضعیت')
                            ->options(Project::STATUSES),

                        TextInput::make('province')
                            ->label('استان')
                            ->maxLength(100),

                        TextInput::make('city')
                            ->label('شهر')
                            ->maxLength(100),

                        Textarea::make('description')
                            ->label('شرح')
                            ->rows(4)
                            ->columnSpanFull(),

                    ])
                    ->columns(2),

                Section::make('طرف‌های پروژه')
                    ->schema([

                        Select::make('employer_id')
                            ->label('کارفرما')
                            ->relationship('employer', 'name')
                            ->searchable()
                            ->preload(),

                        Select::make('company_id')
                            ->label('شرکت مجری')
                            ->relationship('company', 'name')
                            ->searchable()
                            ->preload(),

                        Select::make('technician_id')
                            ->label('تکنسین')
                            ->relationship('technician', 'name')
                            ->searchable()
                            ->preload(),

                        Select::make('manufacturer_id')
                            ->label('تولیدکننده')
                            ->relationship('manufacturer', 'name')
                            ->searchable()
                            ->preload(),

                    ])
                    ->columns(2),

                Section::make('نمایش در سایت')
                    ->schema([

                        Toggle::make('is_active')
                            ->label('نمایش در سایت'),

                        Toggle::make('is_verified')
                            ->label('نشان تایید'),

                    ])
                    ->columns(2),

            ]);
    }
}
