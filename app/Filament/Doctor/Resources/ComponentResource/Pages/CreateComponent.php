<?php

namespace App\Filament\Doctor\Resources\ComponentResource\Pages;

use App\Filament\Doctor\Resources\ComponentResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateComponent extends CreateRecord
{
    protected static string $resource = ComponentResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Component created')
            ->body('The Component has been created successfully.');
    }
}
