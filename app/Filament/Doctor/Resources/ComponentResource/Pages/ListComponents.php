<?php

namespace App\Filament\Doctor\Resources\ComponentResource\Pages;

use App\Filament\Doctor\Resources\ComponentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListComponents extends ListRecords
{
    protected static string $resource = ComponentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(), // create
        ];
    }
}
