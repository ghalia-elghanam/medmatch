<?php

namespace App\Filament\Doctor\Resources\MedicineResource\Pages;

use App\Filament\Doctor\Resources\MedicineResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewMedicine extends ViewRecord
{
    protected static string $resource = MedicineResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
