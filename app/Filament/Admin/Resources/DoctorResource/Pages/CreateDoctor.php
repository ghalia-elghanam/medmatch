<?php

namespace App\Filament\Admin\Resources\DoctorResource\Pages;

use App\Enums\RoleType;
use App\Filament\Admin\Resources\DoctorResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateDoctor extends CreateRecord
{
    protected static string $resource = DoctorResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Doctor created')
            ->body('The Doctor has been created successfully.');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['email_verified_at'] = now();

        return $data;
    }

    protected function afterCreate(): void
    {
        $this->record->assignRole(RoleType::doctor->value);
    }
}
