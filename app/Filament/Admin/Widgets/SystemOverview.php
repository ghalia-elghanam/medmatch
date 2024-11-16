<?php

namespace App\Filament\Admin\Widgets;

use App\Enums\RoleType;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SystemOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Patients', User::role(RoleType::patient->value)->count())
                ->icon('heroicon-o-users')
                ->color('primary'),
            Stat::make('Radiologist', User::role(RoleType::radiologist->value)->count())
                ->icon('heroicon-o-viewfinder-circle')
                ->color('primary'),
            Stat::make('Doctors', User::role(RoleType::doctor->value)->count())
                ->icon('heroicon-o-beaker')
                ->color('primary'),
        ];
    }
}
