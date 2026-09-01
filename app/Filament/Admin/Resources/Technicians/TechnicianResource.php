<?php

namespace App\Filament\Admin\Resources\Technicians;

use App\Filament\Admin\Resources\Technicians\Pages\EditTechnician;
use App\Filament\Admin\Resources\Technicians\Pages\ListTechnicians;
use App\Filament\Admin\Resources\Technicians\Schemas\TechnicianForm;
use App\Filament\Admin\Resources\Technicians\Tables\TechniciansTable;
use App\Models\Technician;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class TechnicianResource extends Resource
{
    protected static ?string $model = Technician::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedWrenchScrewdriver;

    protected static string|UnitEnum|null $navigationGroup = 'کاربران';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationLabel = 'تکنسین‌ها';
    protected static ?string $modelLabel = 'تکنسین';
    protected static ?string $pluralModelLabel = 'تکنسین‌ها';

    protected static ?string $recordTitleAttribute = 'name';


    public static function form(Schema $schema): Schema
    {
        return TechnicianForm::configure($schema);
    }


    public static function table(Table $table): Table
    {
        return TechniciansTable::configure($table);
    }


    /*
    | ساختن پروفایل از اینجا ممکن نیست چون هر پروفایل به یک حساب کاربری
    | گره خورده است؛ پروفایل بی‌صاحب در سایت قابل ویرایش نخواهد بود.
    */
    public static function getPages(): array
    {
        return [
            'index' => ListTechnicians::route('/'),
            'edit'  => EditTechnician::route('/{record}/edit'),
        ];
    }
}
