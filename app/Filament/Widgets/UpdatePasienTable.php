<?php

namespace App\Filament\Widgets;

use App\Models\Pasien;
use App\Models\Riwayat;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Carbon\Carbon;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Forms\Components\DatePicker; // Menambahkan DatePicker untuk filter tanggal
use Filament\Forms\Form;

class UpdatePasienTable extends BaseWidget
{
    protected static ?string $heading = 'Update Data Pasien';
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 'full';

    // Menambahkan properti untuk menyimpan filter
    protected $filters = [
        'startDate' => null,
        'endDate' => null,
    ];

    public function table(Table $table): Table
    {
        $startDate = $this->filters['startDate'] ?? null;
        $endDate = $this->filters['endDate'] ?? null;

        // Menyesuaikan query berdasarkan filter tanggal
        $query = Riwayat::query();

        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        return $table
            ->query($query)
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('created_at')
                    ->dateTime()
                    ->label('Tanggal')
                    ->formatStateUsing(fn($state) => Carbon::parse($state)->format('d/m/Y')),
                TextColumn::make('pasien.nama')
                    ->label('Nama Pasien'),
                TextColumn::make('keluhan')
                    ->label('Keluhan'),
                TextColumn::make('status_pasien')
                    ->badge()
                    ->color(function (string $state): string {
                        return match ($state) {
                            'Dirawat'  => 'danger',
                            'Membaik' => 'success',
                        };
                    }),
            ]);
    }

    // Menambahkan form untuk filter tanggal
    public function filtersForm(Form $form): Form
    {
        return $form->schema([
            DatePicker::make('startDate')
                ->label('Start Date')
                ->reactive()
                ->afterStateUpdated(function ($state) {
                    $this->filters['startDate'] = $state;
                }),

            DatePicker::make('endDate')
                ->label('End Date')
                ->reactive()
                ->afterStateUpdated(function ($state) {
                    $this->filters['endDate'] = $state;
                }),
        ]);
    }
}
