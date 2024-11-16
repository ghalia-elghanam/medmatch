<?php

namespace App\Filament\Doctor\Resources\ResultResource\Pages;

use App\Filament\Doctor\Resources\ResultResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditResult extends EditRecord
{
    protected static string $resource = ResultResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('User edited')
            ->body('The User has been edited successfully.');
    }
}
