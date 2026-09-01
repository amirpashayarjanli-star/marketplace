<?php

namespace App\Filament\Admin\Resources\Projects;

use App\Filament\Admin\Resources\Projects\Pages\EditProject;
use App\Filament\Admin\Resources\Projects\Pages\ListProjects;
use App\Filament\Admin\Resources\Projects\Schemas\ProjectForm;
use App\Filament\Admin\Resources\Projects\Tables\ProjectsTable;
use App\Models\Project;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static string|UnitEnum|null $navigationGroup = 'محتوا';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'پروژه‌ها';
    protected static ?string $modelLabel = 'پروژه';
    protected static ?string $pluralModelLabel = 'پروژه‌ها';

    protected static ?string $recordTitleAttribute = 'title';


    public static function form(Schema $schema): Schema
    {
        return ProjectForm::configure($schema);
    }


    public static function table(Table $table): Table
    {
        return ProjectsTable::configure($table);
    }


    public static function getPages(): array
    {
        return [
            'index' => ListProjects::route('/'),
            'edit'  => EditProject::route('/{record}/edit'),
        ];
    }
}
