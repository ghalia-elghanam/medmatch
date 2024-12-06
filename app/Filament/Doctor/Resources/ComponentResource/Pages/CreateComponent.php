<?php

namespace App\Filament\Doctor\Resources\ComponentResource\Pages;

use App\Filament\Doctor\Resources\ComponentResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateComponent extends CreateRecord
{
    protected static string $resource = ComponentResource::class;

    // دي الفنكشن اللي بترجعك للجدول تاني
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    // دا الاشعار اللي بيوصل
    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Component created')
            ->body('The Component has been created successfully.');
    }
}
