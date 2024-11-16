<?php

namespace App\Filament\Auth;

use App\Enums\RoleType;
use App\Models\User;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Auth\Register as AuthRegister;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class Register extends AuthRegister
{
    public function getHeading(): string|Htmlable
    {
        return __('Doctor Registration');
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            $this->getNameFormComponent(),
            $this->getEmailFormComponent(),
            TextInput::make('password')
                ->label(__('filament-panels::pages/auth/register.form.password.label'))
                ->password()
                ->revealable(filament()->arePasswordsRevealable())
                ->required()
                ->rule(Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols(), )
                ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                ->same('passwordConfirmation')
                ->validationAttribute(__('filament-panels::pages/auth/register.form.password.validation_attribute')),
            $this->getPasswordConfirmationFormComponent(),
            TextInput::make('ssn')
                ->label('ssn')
                ->rule(['digits:10', 'unique:users,ssn'])
                ->numeric(),
            $this->getRoleFormComponent(),

        ])->statePath('data');
    }

    protected function getRoleFormComponent(): Component
    {
        return Select::make('role')
            ->options([
                'doctor' => RoleType::doctor->value,
                'radiologist' => RoleType::radiologist->value,
            ])
            ->required();
    }

    protected function handleRegistration(array $data): Model
    {
        $user = $this->getUserModel()::create(collect($data)->except('role')->toArray());
        $user->update([
            'email_verified_at' => now(),
        ]);
        $user->assignRole($data['role']);
        // send notification for admin
        $admin = User::where('email', 'admin@gmail.com')->first();
        Notification::make()
            ->icon('heroicon-o-users')
            ->iconColor('primary')
            ->success()
            ->title('New User Has Recently Registerd')
            ->body('Name: '.$user->name.' && Role: '.$user->getRoleNames()[0])
            ->sendToDatabase($admin);

        return $user;
    }
}
