<?php

namespace App\Filament\Doctor\Resources\DiseaseResource\Pages;

use App\Filament\Doctor\Resources\DiseaseResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateDisease extends CreateRecord
{
    protected static string $resource = DiseaseResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Disease created')
            ->body('The Disease has been created successfully.');
    }
}
