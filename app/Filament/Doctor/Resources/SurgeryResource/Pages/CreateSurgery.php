<?php

namespace App\Filament\Doctor\Resources\SurgeryResource\Pages;

use App\Filament\Doctor\Resources\SurgeryResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateSurgery extends CreateRecord
{
    protected static string $resource = SurgeryResource::class;

    protected function getRedirectUrl(): string
    {
        // بيحولك علي الصفحة الرئيسية
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        // اظهار الاشعارات
        return Notification::make()
            ->success()
            ->title('Surgery created')
            ->body('The Surgery has been created successfully.');
    }
}
