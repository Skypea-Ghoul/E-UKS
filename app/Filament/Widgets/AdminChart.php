<?php

namespace App\Filament\Widgets;

use App\Models\Pasien;
use Carbon\Carbon;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class AdminChart extends ApexChartWidget
{
    /**
     * Chart Id
     *
     * @var string
     */
    protected static ?string $chartId = 'adminChart';
    protected static ?int $sort = 2;
    use InteractsWithPageFilters;

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Rekap Data Pasien Bulanan';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {

        $Start = $this->filters['startDate'];
        $End = $this->filters['endDate'];
        // Ambil data pasien per bulan
        $data = Trend::model(Pasien::class)
            ->between(
                start: $Start ? Carbon::parse($Start) : now()->startOfYear(),
                end: $End ? Carbon::parse($End) : now()->endOfYear()
            )
            ->perMonth()
            ->count();

        // Format data untuk chart
        $chartData = $data->map(fn(TrendValue $value) => $value->aggregate);
        $chartLabels = $data->map(fn(TrendValue $value) => Carbon::parse($value->date)->format('F'));

        return [
            'chart' => [
                'type' => 'line',
                'height' => 300,
            ],
            'series' => [
                [
                    'name' => 'Pasien Bulanan (Kolom)',
                    'data' => $chartData,  // Menampilkan data pasien di grafik kolom
                    'type' => 'column',  // Grafik jenis kolom
                ],
                [
                    'name' => 'Pasien Bulanan (Garis)',
                    'data' => $chartData,  // Menampilkan data pasien di grafik garis
                    'type' => 'line',  // Grafik jenis garis
                ],
            ],
            'stroke' => [
                'width' => [0, 4],
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
                        'fontFamily' => 'poppins',  // Menyesuaikan font
                    ],
                ],
            ],
            'legend' => [
                'labels' => [
                    'fontFamily' => 'poppins',  // Menyesuaikan font di legend
                ],
            ],
        ];
    }
}
