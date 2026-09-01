<?php

namespace App\Filament\Admin\Resources\Employers\Pages;

use App\Filament\Admin\Resources\Employers\EmployerResource;
use Filament\Resources\Pages\ListRecords;

class ListEmployers extends ListRecords
{
    protected static string $resource = EmployerResource::class;
}
