<?php

namespace App\Filament\Doctor\Resources\ComponentResource\Pages;

use App\Filament\Doctor\Resources\ComponentResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditComponent extends EditRecord
{
    protected static string $resource = ComponentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(), // view
            Actions\DeleteAction::make(), // delete
        ];
    }
    // دي الفنكشن اللي بترجعك للجدول تاني
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    // دا الاشعار اللي بيوصل
    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Component edited')
            ->body('The Component has been edited successfully.');
    }
}
