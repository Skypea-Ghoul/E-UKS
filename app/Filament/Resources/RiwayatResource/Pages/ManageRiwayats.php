<?php

namespace App\Filament\Resources\RiwayatResource\Pages;

use App\Filament\Resources\RiwayatResource;
use Filament\Actions;
use Filament\Pages\Actions\Modal\Actions\ButtonAction;
use Filament\Resources\Pages\ManageRecords;

class ManageRiwayats extends ManageRecords
{
    protected static string $resource = RiwayatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            // ButtonAction::make('Laporan pdf')->url(fn() => route('download.riwayat')),
        ];
    }
}
