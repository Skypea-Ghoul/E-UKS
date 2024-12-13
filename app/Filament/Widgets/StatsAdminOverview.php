<?php

namespace App\Filament\Widgets;

use App\Models\Obat;
use App\Models\Pasien;
use App\Models\Riwayat;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsAdminOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    use InteractsWithPageFilters;

    protected function getStats(): array
    {
        // Ambil filter berdasarkan tanggal
        $Start = $this->filters['startDate'] ?? null;
        $End = $this->filters['endDate'] ?? null;

        // Pasien
        $pasienQuery = Pasien::query();
        if ($Start) {
            $pasienQuery->whereDate('created_at', '>=', $Start);
        }
        if ($End) {
            $pasienQuery->whereDate('created_at', '<=', $End);
        }
        $pasienCount = $pasienQuery->count();

        // Dirawat
        $dirawatCount = Riwayat::query()
            ->where('status_pasien', 'Dirawat')
            ->when($Start, fn($query) => $query->whereDate('created_at', '>=', $Start))
            ->when($End, fn($query) => $query->whereDate('created_at', '<=', $End))
            ->count();

        // Membaik
        $membaikCount = Riwayat::query()
            ->where('status_pasien', 'Membaik')
            ->when($Start, fn($query) => $query->whereDate('created_at', '>=', $Start))
            ->when($End, fn($query) => $query->whereDate('created_at', '<=', $End))
            ->count();

        // Obat
        $obatCount = Obat::query()
            ->when($Start, fn($query) => $query->whereDate('created_at', '>=', $Start))
            ->when($End, fn($query) => $query->whereDate('created_at', '<=', $End))
            ->count();

        return [
            Stat::make('Pasien', $pasienCount)
                ->description('Banyak Data Pasien')
                ->descriptionIcon('heroicon-o-user')
                ->chart([1, 3, 5, 10, 20, 40])
                ->color('sky'),

            Stat::make('Dirawat', $dirawatCount)
                ->description('Banyak Pasien Yang Dirawat')
                ->descriptionIcon('heroicon-o-eye-dropper')
                ->chart([50, 40, 30, 30, 40, 50])
                ->color('info'),

            Stat::make('Membaik', $membaikCount)
                ->description('Banyak Pasien Yang Membaik')
                ->descriptionIcon('heroicon-o-user-plus')
                ->chart([50, 40, 30, 30, 40, 50])
                ->color('success'),

            Stat::make('Obat', $obatCount)
                ->description('Banyak Obat')
                ->descriptionIcon('heroicon-o-beaker')
                ->chart([50, 40, 5, 10, 40, 20])
                ->color('warning'),
        ];
    }
}
