<?php

namespace App\Filament\Doctor\Resources\AllergyResource\Pages;

use App\Filament\Doctor\Resources\AllergyResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAllergy extends ViewRecord
{
    protected static string $resource = AllergyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
