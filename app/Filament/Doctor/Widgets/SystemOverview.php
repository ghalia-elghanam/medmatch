<?php

namespace App\Filament\Doctor\Widgets;

use App\Enums\RoleType;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SystemOverview extends BaseWidget
{
    protected static ?int $sort = 3;

    protected function getStats(): array
    {
        return [
            Stat::make('Patients', User::role(RoleType::patient->value)->count())
                ->icon('heroicon-o-users'), // hero icon

            Stat::make('Radiologist', User::role(RoleType::radiologist->value)->count())
                ->icon('heroicon-o-viewfinder-circle'),

            Stat::make('Doctors', User::role(RoleType::doctor->value)->count())
                ->icon('heroicon-o-beaker'),
        ];
    }
}