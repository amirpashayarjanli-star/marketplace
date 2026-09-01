<?php

namespace App\Filament\Admin\Resources\Employers\Tables;

use App\Filament\Admin\Support\DirectoryProfile;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

/*
| جدول کارفرما امتیاز ندارد — برخلاف بقیه‌ی پروفایل‌ها، جدول employers
| ستون rating/reviews_count ندارد چون کارفرما در دایرکتوری امتیاز نمی‌گیرد.
*/
class EmployersTable
{
    public static function configure(Table $table): Table
    {
        return DirectoryProfile::table($table, [

            TextColumn::make('projects_count')
                ->label('پروژه')
                ->counts('projects'),

            TextColumn::make('auctions_count')
                ->label('مزایده')
                ->counts('auctions'),

        ], hasRating: false);
    }
}
