<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JadwalResource\Pages;
use App\Models\Jadwal;
use App\Models\Riwayat;
use App\Models\Pasien;
use Filament\Forms;
use Filament\Infolists\Components\Section;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Set;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;

class JadwalResource extends Resource
{
    protected static ?string $model = Jadwal::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard';
    protected static ?string $label = 'Jadwal Pasien';
    protected static ?string $navigationGroup = 'Menu';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('pasien_id')
                    ->label('Nama Pasien')
                    ->relationship('pasien', 'nama', function (Builder $query) {
                        $query->whereHas('riwayats', function ($query) {
                            $query->where('status_pasien', 'Dirawat');
                        });
                    })
                    ->preload()
                    ->afterStateUpdated(function (Set $set, $state) {
                        $pasien = Pasien::find($state);
                        if ($pasien) {
                            $riwayat = $pasien->riwayats()->where('status_pasien', 'Dirawat')->first();
                            if ($riwayat) {
                                $set('riwayat_id', $riwayat->id);
                            } else {
                                $set('riwayat_id', null);
                            }
                        }
                    }),

                Select::make('kamar')
                    ->options([
                        '1' => '1',
                        '2' => '2',
                        '3' => '3',
                        '4' => '4',
                    ])
                    ->required(),
                DateTimePicker::make('jam_masuk')
                    ->label('Jam Masuk')
                    ->required(),
                DateTimePicker::make('jam_keluar')
                    ->label('Jam Keluar')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('pasien.nis')
                    ->searchable()
                    ->label('Nis'),
                Tables\Columns\TextColumn::make('pasien.nama')
                    ->searchable()
                    ->label('Pasien'),
                Tables\Columns\TextColumn::make('kamar')
                    ->searchable()
                    ->label('Kamar'),
                Tables\Columns\TextColumn::make('jam_masuk')
                    ->dateTime('H:i', 'Asia/Jakarta')
                    ->label('Jam Masuk'),
                Tables\Columns\TextColumn::make('jam_keluar')
                    ->dateTime('H:i', 'Asia/Jakarta')
                    ->label('Jam Keluar'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Info Jadwal Pasien')
                    ->schema([
                        TextEntry::make('pasien.nama')
                            ->label('Nama'),
                        TextEntry::make('kamar')
                            ->label('Kamar'),
                        TextEntry::make('jam_masuk')
                            ->label('Jam Masuk')
                            ->dateTime('H:i', 'Asia/Jakarta'),
                        TextEntry::make('jam_keluar')
                            ->label('Jam Keluar')
                            ->dateTime('H:i', 'Asia/Jakarta'),
                    ])->columns(2)
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJadwals::route('/'),
        ];
    }
}
