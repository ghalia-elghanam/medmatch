<?php

namespace App\Filament\Admin\Resources\RadiologistResource\Pages;

use App\Filament\Admin\Resources\RadiologistResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditRadiologist extends EditRecord
{
    protected static string $resource = RadiologistResource::class;

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
            ->title('Radiologist edited')
            ->body('The Radiologist has been edited successfully.');
    }
}
