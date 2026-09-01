<?php

namespace App\Filament\Admin\Resources\ProjectInquiries;

use App\Filament\Admin\Resources\ProjectInquiries\Pages\ListProjectInquiries;
use App\Filament\Admin\Resources\ProjectInquiries\Tables\ProjectInquiriesTable;
use App\Models\ProjectInquiry;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

/**
 * استعلام‌های پروژه فقط خواندنی‌اند — پذیرش و رد را خود کارفرما از
 * داشبوردش انجام می‌دهد؛ اینجا برای پیگیری و پشتیبانی است.
 */
class ProjectInquiryResource extends Resource
{
    protected static ?string $model = ProjectInquiry::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedInboxArrowDown;

    protected static string|UnitEnum|null $navigationGroup = 'محتوا';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'استعلام‌ها';
    protected static ?string $modelLabel = 'استعلام';
    protected static ?string $pluralModelLabel = 'استعلام‌ها';


    public static function table(Table $table): Table
    {
        return ProjectInquiriesTable::configure($table);
    }


    public static function canCreate(): bool
    {
        return false;
    }


    public static function getPages(): array
    {
        return [
            'index' => ListProjectInquiries::route('/'),
        ];
    }
}
