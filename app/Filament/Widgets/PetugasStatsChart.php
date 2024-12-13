<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Carbon\Carbon;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class PetugasStatsChart extends ApexChartWidget
{
    /**
     * Chart Id
     *
     * @var string
     */
    protected static ?string $chartId = 'petugasStatsChart';
    protected static ?int $sort = 2;
    use InteractsWithPageFilters;


    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Rekap Data Petugas';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {
        // Ambil data petugas per bulan dari model User
        $Start = $this->filters['startDate'] ?? now()->startOfYear();
        $End = $this->filters['endDate'] ?? now()->endOfYear();

        $data = Trend::model(User::class)
            ->between(
                start: Carbon::parse($Start),
                end: Carbon::parse($End)
            )
            ->perMonth()
            ->count();

        $chartData = $data->map(fn(TrendValue $value) => $value->aggregate);
        $chartLabels = $data->map(fn(TrendValue $value) => Carbon::parse($value->date)->format('F'));

        return [
            'chart' => [
                'type' => 'area',
                'height' => 300,
            ],
            'series' => [
                [
                    'name' => 'Petugas Bulanan',
                    'data' => $chartData,
                ],
            ],
            'xaxis' => [
                'categories' => $chartLabels,
                'labels' => [
                    'style' => [
                        'fontFamily' => 'poppins',
                    ],
                ],
            ],
            'yaxis' => [
                'labels' => [
                    'style' => [
                        'fontFamily' => 'poppins',
                    ],
                ],
            ],
            'colors' => ['#f59e0b'],
            'stroke' => [
                'curve' => 'smooth',
            ],
            'dataLabels' => [
                'enabled' => false,
            ],
        ];
    }
}
