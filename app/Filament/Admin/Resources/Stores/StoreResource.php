<?php

namespace App\Filament\Admin\Resources\Stores;

use App\Filament\Admin\Resources\Stores\Pages\EditStore;
use App\Filament\Admin\Resources\Stores\Pages\ListStores;
use App\Filament\Admin\Resources\Stores\Schemas\StoreForm;
use App\Filament\Admin\Resources\Stores\Tables\StoresTable;
use App\Models\Store;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class StoreResource extends Resource
{
    protected static ?string $model = Store::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingStorefront;

    protected static string|UnitEnum|null $navigationGroup = 'کاربران';

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationLabel = 'فروشگاه‌ها';
    protected static ?string $modelLabel = 'فروشگاه';
    protected static ?string $pluralModelLabel = 'فروشگاه‌ها';

    protected static ?string $recordTitleAttribute = 'name';


    public static function form(Schema $schema): Schema
    {
        return StoreForm::configure($schema);
    }


    public static function table(Table $table): Table
    {
        return StoresTable::configure($table);
    }


    /*
    | ساختن پروفایل از اینجا ممکن نیست چون هر پروفایل به یک حساب کاربری
    | گره خورده است؛ پروفایل بی‌صاحب در سایت قابل ویرایش نخواهد بود.
    */
    public static function getPages(): array
    {
        return [
            'index' => ListStores::route('/'),
            'edit'  => EditStore::route('/{record}/edit'),
        ];
    }
}
