<?php

namespace App\Filament\Auth;

use Filament\Pages\Auth\Login as AuthLogin;
use Illuminate\Contracts\Support\Htmlable;

class AdminLogin extends AuthLogin
{
    public function getHeading(): string|Htmlable
    {
        return __('Admin Login');
    }
}
