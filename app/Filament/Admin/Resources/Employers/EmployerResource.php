<?php

namespace App\Filament\Admin\Resources\Employers;

use App\Filament\Admin\Resources\Employers\Pages\EditEmployer;
use App\Filament\Admin\Resources\Employers\Pages\ListEmployers;
use App\Filament\Admin\Resources\Employers\Schemas\EmployerForm;
use App\Filament\Admin\Resources\Employers\Tables\EmployersTable;
use App\Models\Employer;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class EmployerResource extends Resource
{
    protected static ?string $model = Employer::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBriefcase;

    protected static string|UnitEnum|null $navigationGroup = 'کاربران';

    protected static ?int $navigationSort = 6;

    protected static ?string $navigationLabel = 'کارفرماها';
    protected static ?string $modelLabel = 'کارفرما';
    protected static ?string $pluralModelLabel = 'کارفرماها';

    protected static ?string $recordTitleAttribute = 'name';


    public static function form(Schema $schema): Schema
    {
        return EmployerForm::configure($schema);
    }


    public static function table(Table $table): Table
    {
        return EmployersTable::configure($table);
    }


    /*
    | ساختن پروفایل از اینجا ممکن نیست چون هر پروفایل به یک حساب کاربری
    | گره خورده است؛ پروفایل بی‌صاحب در سایت قابل ویرایش نخواهد بود.
    */
    public static function getPages(): array
    {
        return [
            'index' => ListEmployers::route('/'),
            'edit'  => EditEmployer::route('/{record}/edit'),
        ];
    }
}
