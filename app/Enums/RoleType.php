<?php

namespace App\Enums;

enum RoleType: string
{
    case doctor = 'doctor';
    case radiologist = 'radiologist';
    case receptionist = 'receptionist';
    case admin = 'admin';
    case patient = 'patient';
}
