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
    // دي بتحط ال heading
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
                ->rule(
                    Password::min(8) //length 8
                        ->mixedCase() // A a
                        ->numbers() // 45
                        ->symbols(), // & $ #
                )
                ->dehydrateStateUsing(fn ($state) => Hash::make($state)) // hashing (md5)
                ->same('passwordConfirmation') // check password = passwordconfirmation
                ->validationAttribute(__('filament-panels::pages/auth/register.form.password.validation_attribute')),
            $this->getPasswordConfirmationFormComponent(), // passwordconfirmation
            TextInput::make('ssn')
                ->label('ssn')
                ->rule(['unique:users,ssn']),
            $this->getRoleFormComponent(), // role

        ])->statePath('data');
    }

    // to select role when register
    protected function getRoleFormComponent(): Component
    {
        return Select::make('role')
            ->options([
                RoleType::doctor->value => RoleType::doctor->name,
                RoleType::radiologist->value => RoleType::radiologist->name,
                RoleType::receptionist->value => RoleType::receptionist->name,
            ])
            ->required();
    }

    protected function handleRegistration(array $data): Model
    {
        // collect every feild except role
        $user = $this->getUserModel()::create(collect($data)->except('role')->toArray());
        // verify email
        $user->update([
            'email_verified_at' => now(),
        ]);
        // take role from select
        $user->assignRole($data['role']);
        // send notification for admin
        $admin = User::where('email', 'admin@gmail.com')->first(); // get admin
        // send notification to him
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
