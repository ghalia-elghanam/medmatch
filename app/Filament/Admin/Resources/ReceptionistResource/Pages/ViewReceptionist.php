<?php

namespace App\Filament\Admin\Resources\ReceptionistResource\Pages;

use App\Filament\Admin\Resources\ReceptionistResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewReceptionist extends ViewRecord
{
    protected static string $resource = ReceptionistResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
