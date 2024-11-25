<?php

namespace App\Filament\Doctor\Widgets;

use App\Enums\RoleType;
use App\Models\User;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class PatientChart extends ApexChartWidget
{
    protected static ?int $sort = 2; // order

    protected static ?string $heading = 'Total Patients Per Month'; // heading

    protected function getOptions(): array
    {
        $data = Trend::query(User::role(RoleType::patient->value)) // patient
            // 1 - 12
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            // x axis (1-2-3-...-12)
            ->perMonth()
            // count of patients in this month
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
            // cart
            'series' => [
                [
                    'name' => 'Patients Added',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    // جمع كل المرضي خلال الشهر
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
