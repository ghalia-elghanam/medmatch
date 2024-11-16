<?php

namespace App\Filament\Doctor\Widgets;

use App\Enums\RoleType;
use App\Models\User;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class PatientChart extends ApexChartWidget
{
    protected static ?int $sort = 2;

    protected static ?string $chartId = 'patientChart';

    protected static ?string $heading = 'Total Patients Per Month';

    protected function getOptions(): array
    {
        $data = Trend::query(User::role(RoleType::patient->value))
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();

        return [
            'chart' => [
                'type' => 'line',
                'height' => 300,
            ],
            'colors' => ['#2F919F'],
            'stroke' => [
                'curve' => 'smooth',
            ],
            'series' => [
                [
                    'name' => 'Patients Added',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'xaxis' => [
                'categories' => $data->map(fn (TrendValue $value) => $value->date),
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'yaxis' => [
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],

        ];
    }
}
