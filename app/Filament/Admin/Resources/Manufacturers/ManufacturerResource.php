<?php

namespace App\Filament\Admin\Resources\Manufacturers;

use App\Filament\Admin\Resources\Manufacturers\Pages\EditManufacturer;
use App\Filament\Admin\Resources\Manufacturers\Pages\ListManufacturers;
use App\Filament\Admin\Resources\Manufacturers\Schemas\ManufacturerForm;
use App\Filament\Admin\Resources\Manufacturers\Tables\ManufacturersTable;
use App\Models\Manufacturer;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ManufacturerResource extends Resource
{
    protected static ?string $model = Manufacturer::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static string|UnitEnum|null $navigationGroup = 'کاربران';

    protected static ?int $navigationSort = 5;

    protected static ?string $navigationLabel = 'تولیدکننده‌ها';
    protected static ?string $modelLabel = 'تولیدکننده';
    protected static ?string $pluralModelLabel = 'تولیدکننده‌ها';

    protected static ?string $recordTitleAttribute = 'name';


    public static function form(Schema $schema): Schema
    {
        return ManufacturerForm::configure($schema);
    }


    public static function table(Table $table): Table
    {
        return ManufacturersTable::configure($table);
    }


    /*
    | ساختن پروفایل از اینجا ممکن نیست چون هر پروفایل به یک حساب کاربری
    | گره خورده است؛ پروفایل بی‌صاحب در سایت قابل ویرایش نخواهد بود.
    */
    public static function getPages(): array
    {
        return [
            'index' => ListManufacturers::route('/'),
            'edit'  => EditManufacturer::route('/{record}/edit'),
        ];
    }
}
