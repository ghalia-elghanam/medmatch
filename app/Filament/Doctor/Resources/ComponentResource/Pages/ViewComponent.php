<?php

namespace App\Filament\Doctor\Resources\ComponentResource\Pages;

use App\Filament\Doctor\Resources\ComponentResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewComponent extends ViewRecord
{
    protected static string $resource = ComponentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(), // edit
        ];
    }
}
