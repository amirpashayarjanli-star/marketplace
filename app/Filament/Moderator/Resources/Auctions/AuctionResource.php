<?php

namespace App\Filament\Moderator\Resources\Auctions;

use App\Filament\Admin\Resources\Auctions\RelationManagers\BidsRelationManager;
use App\Filament\Admin\Resources\Auctions\Schemas\AuctionForm;
use App\Filament\Admin\Resources\Auctions\Tables\AuctionsTable;
use App\Filament\Moderator\Resources\Auctions\Pages\CreateAuction;
use App\Filament\Moderator\Resources\Auctions\Pages\EditAuction;
use App\Filament\Moderator\Resources\Auctions\Pages\ListAuctions;
use App\Models\Auction;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;


/*
| همان منابع پنل ادمین را دوباره استفاده می‌کند — فرم و جدول یکی هستند،
| فقط صفحه‌ها باید جدا باشند چون مسیرشان زیر پنل moderator ثبت می‌شود.
*/

class AuctionResource extends Resource
{
    protected static ?string $model = Auction::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedScale;

    protected static ?string $navigationLabel = 'پرو مزایده';
    protected static ?string $modelLabel = 'مزایده';
    protected static ?string $pluralModelLabel = 'مزایده‌ها';

    protected static ?string $recordTitleAttribute = 'title';


    public static function form(Schema $schema): Schema
    {
        return AuctionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AuctionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            BidsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListAuctions::route('/'),
            'create' => CreateAuction::route('/create'),
            'edit'   => EditAuction::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        // هر چیزی که منتظر اقدام ماست: مشاوره‌ی انجام‌نشده + تایید نهایی
        $pending = static::getModel()::whereIn('status', ['pending_review', 'awaiting_consultation'])->count();

        return $pending > 0 ? (string) $pending : null;
    }
}
