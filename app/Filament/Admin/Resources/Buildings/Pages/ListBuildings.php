<?php

namespace App\Filament\Admin\Resources\Buildings\Pages;

use App\Filament\Admin\Resources\Buildings\BuildingResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;

class ListBuildings extends ListRecords
{
    protected static string $resource = BuildingResource::class;

    /*
    | ساخت پرونده به صفحه‌ی دست‌ساز می‌رود، نه فرم Filament — آنجا
    | حساب کاربری و پروفایل مشتری هم ساخته می‌شود.
    */
    protected function getHeaderActions(): array
    {
        return [
            Action::make('create_file')
                ->label('پرونده‌ی جدید')
                ->icon(Heroicon::OutlinedPlus)
                ->url(route('admin.buildings.create')),
        ];
    }
}
