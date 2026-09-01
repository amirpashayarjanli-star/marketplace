<?php

namespace App\Filament\Admin\Resources\Buildings;

use App\Filament\Admin\Resources\Buildings\Pages\EditBuilding;
use App\Filament\Admin\Resources\Buildings\Pages\ListBuildings;
use App\Filament\Admin\Resources\Buildings\RelationManagers\ElevatorsRelationManager;
use App\Filament\Admin\Resources\Buildings\Schemas\BuildingForm;
use App\Filament\Admin\Resources\Buildings\Tables\BuildingsTable;
use App\Models\Building;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

/*
| پرونده‌ها تا امروز فقط از داخل قراردادشان قابل دیدن بودند، پس پرونده‌ی
| بدون قرارداد عملاً گم می‌شد. ساختِ پرونده همچنان از صفحه‌ی دست‌ساز
| انجام می‌شود، چون آنجا حساب مشتری هم ساخته می‌شود.
*/
class BuildingResource extends Resource
{
    protected static ?string $model = Building::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice2;

    protected static string|UnitEnum|null $navigationGroup = 'پرو سرویس';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'پرونده‌ها';
    protected static ?string $modelLabel = 'پرونده';
    protected static ?string $pluralModelLabel = 'پرونده‌ها';

    protected static ?string $recordTitleAttribute = 'title';


    public static function form(Schema $schema): Schema
    {
        return BuildingForm::configure($schema);
    }


    public static function table(Table $table): Table
    {
        return BuildingsTable::configure($table);
    }


    public static function getRelations(): array
    {
        return [
            ElevatorsRelationManager::class,
        ];
    }


    public static function getPages(): array
    {
        return [
            'index' => ListBuildings::route('/'),
            'edit'  => EditBuilding::route('/{record}/edit'),
        ];
    }
}
