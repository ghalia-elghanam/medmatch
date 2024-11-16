<?php

namespace App\Filament\Doctor\Resources\SurgeryResource\Pages;

use App\Filament\Doctor\Resources\SurgeryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSurgeries extends ListRecords
{
    protected static string $resource = SurgeryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
