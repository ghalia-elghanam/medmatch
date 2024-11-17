<?php

namespace App\Filament\Admin\Resources\RadiologistResource\Pages;

use App\Enums\RoleType;
use App\Filament\Admin\Resources\RadiologistResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateRadiologist extends CreateRecord
{
    protected static string $resource = RadiologistResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Radiologist created')
            ->body('The Radiologist has been created successfully.');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['email_verified_at'] = now();

        return $data;
    }

    protected function afterCreate(): void
    {
        $this->record->assignRole(RoleType::radiologist->value);
    }
}
