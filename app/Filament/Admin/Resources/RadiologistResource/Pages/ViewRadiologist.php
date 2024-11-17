<?php

namespace App\Filament\Admin\Resources\RadiologistResource\Pages;

use App\Filament\Admin\Resources\RadiologistResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewRadiologist extends ViewRecord
{
    protected static string $resource = RadiologistResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
