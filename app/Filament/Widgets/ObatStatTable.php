<?php

namespace App\Filament\Widgets;

use App\Models\Obat;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class ObatStatTable extends BaseWidget
{
    protected static ?string $heading = 'Data Obat';
    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = 'full';
    public function table(Table $table): Table
    {
        return $table
            ->query(Obat::query())
            ->defaultSort('created_at', 'desc')
            ->columns([

                TextColumn::make('nama_obat')
                    ->label('Nama Obat'),
                TextColumn::make('jumlah_obat')
                    ->label('Jumlah Obat'),
                TextColumn::make('status_obat')
                    ->badge()
                    ->color(function (string $state): string {
                        return match ($state) {
                            'Tidak Tersedia'  => 'danger',
                            'Tersedia' => 'success',
                        };
                    }),
            ]);
    }
}
