<?php

namespace App\Filament\Admin\Resources\ReceptionistResource\Pages;

use App\Filament\Admin\Resources\ReceptionistResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReceptionist extends EditRecord
{
    protected static string $resource = ReceptionistResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
