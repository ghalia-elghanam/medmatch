<?php

namespace App\Filament\Doctor\Resources\AllergyResource\Pages;

use App\Filament\Doctor\Resources\AllergyResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateAllergy extends CreateRecord
{
    protected static string $resource = AllergyResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Allergy created')
            ->body('The Allergy has been created successfully.');
    }
}
