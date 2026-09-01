<?php

namespace App\Filament\Admin\Resources\Customers;

use App\Filament\Admin\Resources\Customers\Pages\EditCustomer;
use App\Filament\Admin\Resources\Customers\Pages\ListCustomers;
use App\Filament\Admin\Resources\Customers\Schemas\CustomerForm;
use App\Filament\Admin\Resources\Customers\Tables\CustomersTable;
use App\Models\Customer;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserCircle;

    protected static string|UnitEnum|null $navigationGroup = 'پرو سرویس';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'مشتری‌ها';
    protected static ?string $modelLabel = 'مشتری';
    protected static ?string $pluralModelLabel = 'مشتری‌ها';

    protected static ?string $recordTitleAttribute = 'name';


    public static function form(Schema $schema): Schema
    {
        return CustomerForm::configure($schema);
    }


    public static function table(Table $table): Table
    {
        return CustomersTable::configure($table);
    }


    /*
    | ساختن پروفایل از اینجا ممکن نیست چون هر پروفایل به یک حساب کاربری
    | گره خورده است؛ پروفایل بی‌صاحب در سایت قابل ویرایش نخواهد بود.
    */
    public static function getPages(): array
    {
        return [
            'index' => ListCustomers::route('/'),
            'edit'  => EditCustomer::route('/{record}/edit'),
        ];
    }
}
