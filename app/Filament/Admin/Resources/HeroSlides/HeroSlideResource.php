<?php

namespace App\Filament\Admin\Resources\HeroSlides;

use App\Filament\Admin\Resources\HeroSlides\Pages\CreateHeroSlide;
use App\Filament\Admin\Resources\HeroSlides\Pages\EditHeroSlide;
use App\Filament\Admin\Resources\HeroSlides\Pages\ListHeroSlides;
use App\Filament\Admin\Resources\HeroSlides\Schemas\HeroSlideForm;
use App\Filament\Admin\Resources\HeroSlides\Tables\HeroSlidesTable;
use App\Models\HeroSlide;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class HeroSlideResource extends Resource
{
    protected static ?string $model = HeroSlide::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    protected static ?string $navigationLabel = 'اسلایدر صفحه اصلی';
    protected static ?string $modelLabel = 'اسلاید';
    protected static ?string $pluralModelLabel = 'اسلایدهای صفحه اصلی';

    protected static ?string $recordTitleAttribute = 'title';


    public static function form(Schema $schema): Schema
    {
        return HeroSlideForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return HeroSlidesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListHeroSlides::route('/'),
            'create' => CreateHeroSlide::route('/create'),
            'edit'   => EditHeroSlide::route('/{record}/edit'),
        ];
    }
}
