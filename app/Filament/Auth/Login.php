<?php

namespace App\Filament\Auth;

use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Auth\Login as AuthLogin;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Validation\ValidationException;

class Login extends AuthLogin
{
    public function getHeading(): string|Htmlable
    {
        return __('Doctor Login');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                $this->getSsnFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getRememberFormComponent(),
            ])
            ->statePath('data');
    }

    protected function getSsnFormComponent(): Component
    {
        return TextInput::make('ssn')
            ->label('SSN')
            ->required()
            ->autocomplete()
            ->autofocus()
            ->extraInputAttributes(['tabindex' => 1]);
    }

    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'ssn' => $data['ssn'],
            'password' => $data['password'],
        ];
    }

    protected function throwFailureValidationException(): never
    {
        throw ValidationException::withMessages([
            'data.ssn' => __('Invalid SSN'),
        ]);
    }
}
