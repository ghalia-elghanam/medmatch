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
    // دي بتحط ال heading
    public function getHeading(): string|Htmlable
    {
        return __('Doctor Login');
    }

    // عبارة عن حقول الادخال اللي بتستقبل البيانات
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

    // دا تفصيل حقل ال ssn
    protected function getSsnFormComponent(): Component
    {
        return TextInput::make('ssn')
            ->label('SSN')
            ->required()
            ->extraInputAttributes(['tabindex' => 1]);
    }

    // ssn & password
    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'ssn' => $data['ssn'],
            'password' => $data['password'],
        ];
    }


    // error message when ssn wrong or password
    protected function throwFailureValidationException(): never
    {
        throw ValidationException::withMessages([
            'data.ssn' => __('Invalid SSN'),
            'data.password' => __('Invalid Password'),
        ]);
    }
}
