<?php

namespace App\Filament\Doctor\Resources\DiseaseResource\Pages;

use App\Filament\Doctor\Resources\DiseaseResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditDisease extends EditRecord
{
    protected static string $resource = DiseaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Disease edited')
            ->body('The Disease has been edited successfully.');
    }
}
