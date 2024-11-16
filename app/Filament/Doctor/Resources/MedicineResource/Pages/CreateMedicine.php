<?php

namespace App\Filament\Doctor\Resources\MedicineResource\Pages;

use App\Filament\Doctor\Resources\MedicineResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateMedicine extends CreateRecord
{
    protected static string $resource = MedicineResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Medicine created')
            ->body('The Medicine has been created successfully.');
    }
}
