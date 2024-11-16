<?php

namespace App\Enums;

enum RoleType: string
{
    case doctor = 'doctor';
    case admin = 'admin';
    case radiologist = 'radiologist';
    case patient = 'patient';
}
