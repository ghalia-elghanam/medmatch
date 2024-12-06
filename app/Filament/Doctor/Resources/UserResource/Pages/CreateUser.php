<?php

namespace App\Filament\Doctor\Resources\UserResource\Pages;

use App\Enums\RoleType;
use App\Filament\Doctor\Resources\UserResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('User created')
            ->body('The User has been created successfully.');
    }

    // email verify
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['email_verified_at'] = now();

        return $data;
    }

    // take role of patient
    protected function afterCreate(): void
    {
        $this->record->assignRole(RoleType::patient->value);
    }
}
