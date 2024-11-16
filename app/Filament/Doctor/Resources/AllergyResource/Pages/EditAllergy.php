<?php

namespace App\Filament\Doctor\Resources\AllergyResource\Pages;

use App\Filament\Doctor\Resources\AllergyResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditAllergy extends EditRecord
{
    protected static string $resource = AllergyResource::class;

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
            ->title('Allergy edited')
            ->body('The Allergy has been edited successfully.');
    }
}
