<?php

namespace App\Filament\Admin\Resources\Users;

use App\Filament\Admin\Resources\Users\Pages\EditUser;
use App\Filament\Admin\Resources\Users\Pages\ListUsers;
use App\Filament\Admin\Resources\Users\Schemas\UserForm;
use App\Filament\Admin\Resources\Users\Tables\UsersTable;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

/*
| صفحه‌ی «تایید کاربران» فقط کاربران pending را نشان می‌داد. این ریسورس
| همه‌ی کاربران را می‌آورد تا بشود دنبال یک نفر گشت، نقشش را عوض کرد یا
| حسابی را که قبلاً تایید شده بست.
*/
class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    protected static string|UnitEnum|null $navigationGroup = 'کاربران';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'همه‌ی کاربران';
    protected static ?string $modelLabel = 'کاربر';
    protected static ?string $pluralModelLabel = 'کاربران';

    protected static ?string $recordTitleAttribute = 'name';


    public static function form(Schema $schema): Schema
    {
        return UserForm::configure($schema);
    }


    public static function table(Table $table): Table
    {
        return UsersTable::configure($table);
    }


    /**
     * تعداد کاربرانی که منتظر تایید مانده‌اند، کنار نام منو.
     */
    public static function getNavigationBadge(): ?string
    {
        $pending = User::where('status', 'pending')->count();

        return $pending > 0 ? (string) $pending : null;
    }


    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }


    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            'edit'  => EditUser::route('/{record}/edit'),
        ];
    }
}
