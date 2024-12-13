<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RiwayatResource\Pages;
use App\Models\Obat;
use App\Models\Riwayat;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class RiwayatResource extends Resource
{
    protected static ?string $model = Riwayat::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationGroup = 'Menu';
    protected static ?string $label = 'Riwayat Pasien';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('pasien_id')
                    ->label('Nama Pasien')
                    ->relationship('pasien', 'nama')
                    ->required()
                    ->searchable()
                    ->preload(),
                Forms\Components\TextInput::make('keluhan')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('tindakan')
                    ->label('Tindakan'),
                Select::make('status_pasien')
                    ->options([
                        'Dirawat' => 'Dirawat',
                        'Membaik' => 'Membaik'
                    ])
                    ->default('Dirawat')
                    ->required(),
                Hidden::make('user_id')
                    ->default(fn() => Auth::id()),
                Select::make('jenis_obat')
                    ->label('Jenis Obat')
                    ->options([
                        'Obat Pereda Nyeri dan Demam' => 'Obat Pereda Nyeri dan Demam',
                        'Obat Antibiotik' => 'Obat Antibiotik',
                        'Obat Asma dan Penyakit Paru' => 'Obat Asma dan Penyakit Paru',
                        'Obat Flu dan Batuk' => 'Obat Flu dan Batuk',
                        'Obat Pencernaan' => 'Obat Pencernaan',
                        'Obat Luka' => 'Obat Luka',
                        'Obat Alergi' => 'Obat Alergi',
                        'Obat Mata' => 'Obat Mata dan Telinga',
                        'Obat P3K' => 'Obat P3K',
                        'Obat Infeksi Tetanus' => 'Obat Infeksi Tetanus',
                        'Obat Gangguan Seksual' => 'Obat Gangguan Seksual',
                    ])
                    ->disabled(fn($record) => $record !== null)
                    ->default(fn($record) => $record?->jenis_obat)
                    ->visible(fn($record) => $record == null),
                Select::make('obat_id')
                    ->label('Obat')
                    ->options(function (callable $get) {
                        $jenisObat = $get('jenis_obat');
                        if ($jenisObat) {
                            return Obat::where('jenis_obat', $jenisObat)
                                ->where('status_obat', 'Tersedia')
                                ->pluck('nama_obat', 'id');
                        }
                        return Obat::where('status_obat', 'Tersedia')->pluck('nama_obat', 'id');
                    })
                    ->reactive()
                    ->afterStateUpdated(fn(callable $set, $state) => $set('anjuran', Obat::find($state)?->anjuran))
                    ->afterStateUpdated(function (callable $set, $state) {
                        $obat = Obat::find($state);
                        if ($obat) {
                            $set('jumlah_dipakai', $obat->jumlah_dipakai);
                        }
                    })
                    ->searchable()
                    ->preload()
                    ->disabled(fn($record) => $record !== null)  //   Pastikan disabled jika sudah ada obat_id
                    ->default(fn($record) => $record ? $record->obat_id : null)
                    ->visible(fn($record) => $record == null),
                TextInput::make('anjuran')
                    ->label('Anjuran')
                    ->disabled()
                    ->default(fn($record) => $record?->anjuran)
                    ->visible(fn($record) => $record == null),
                TextInput::make('jumlah_dipakai')
                    ->label('Jumlah Obat Dipakai')
                    ->disabled()
                    ->default(fn($record) => $record?->jumlah_dipakai)
                    ->visible(fn($record) => $record == null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('pasien.nis')
                    ->label('Nis')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pasien.nama')
                    ->label('Nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('keluhan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tindakan')
                    ->label('Tindakan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status_pasien')
                    ->badge()
                    ->color(function (string $state): string {
                        return match ($state) {
                            'Dirawat'  => 'danger',
                            'Membaik' => 'success',
                        };
                    }),
                TextColumn::make('obat.nama_obat')
                    ->label('Obat')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('obat.anjuran')
                    ->label('Anjuran Obat')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('obat.jumlah_dipakai')
                    ->label('Jumlah Dipakai')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Petugas')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d F Y H:i', 'Asia/Jakarta')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('user_id')
                    ->label('Nama Petugas')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('status_pasien')
                    ->options([
                        'Dirawat' => 'Dirawat',
                        'Membaik' => 'Membaik'
                    ])
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Action::make('Download PDF')
                    ->label('')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn($record) => route('download.riwayat', ['id' => $record->id])),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Info Riwayat Pasien')
                    ->schema([
                        TextEntry::make('pasien.nis')
                            ->label('NIS'),
                        TextEntry::make('pasien.nama'),
                        TextEntry::make('keluhan'),
                        TextEntry::make('tindakan'),
                        TextEntry::make('status_pasien'),
                        TextEntry::make('user.name')
                            ->label('Petugas'),
                        TextEntry::make('obat.nama_obat')
                            ->label('Obat'),
                        TextEntry::make('obat.anjuran')
                            ->label('Anjuran'),
                        TextEntry::make('obat.jumlah_dipakai')
                            ->label('Jumlah Dipakai')
                    ])->columns(2)
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageRiwayats::route('/'),
        ];
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    protected static function mutateFormDataBeforeCreate(array $data): array
    {
        if (isset($data['obat_id']) && $data['obat_id']) {
            $obat = Obat::find($data['obat_id']);

            if (!$obat) {
                throw new \Exception('Obat tidak ditemukan');
            }

            // Validasi jumlah dipakai apakah angka
            $jumlahDipakai = isset($data['jumlah_dipakai']) ? (int)$data['jumlah_dipakai'] : 0;

            if ($obat->jumlah_obat < $jumlahDipakai) {
                throw new \Exception('Jumlah obat tidak mencukupi. Stok hanya ' . $obat->jumlah_obat);
            }

            // Kurangi stok obat hanya jika jumlah dipakai lebih besar dari 0
            if ($jumlahDipakai >= 0) {
                $obat->decrement('jumlah_obat', $jumlahDipakai);
            }
        }

        return $data;
    }

    protected static function mutateFormDataBeforeSave(array $data): array
    {
        if (isset($data['obat_id']) && $data['obat_id']) {
            $obat = Obat::find($data['obat_id']);

            if (!$obat) {
                throw new \Exception('Obat tidak ditemukan');
            }

            $jumlahDipakai = isset($data['jumlah_dipakai']) ? (int)$data['jumlah_dipakai'] : 0;

            if ($obat->jumlah_obat < $jumlahDipakai) {
                throw new \Exception('Jumlah obat tidak mencukupi. Stok hanya ' . $obat->jumlah_obat);
            }

            // Kurangi stok obat hanya jika jumlah dipakai lebih besar dari 0
            if ($jumlahDipakai > 0) {
                $obat->decrement('jumlah_obat', $jumlahDipakai);
            }
        }

        return $data;
    }

    protected static function afterSave(Form $form, $record): void
    {
        // Tidak ada perubahan pada stok obat saat penyimpanan riwayat
    }

    protected static function afterDelete($record): void
    {
        // Tidak perlu menambahkan kembali stok obat saat penghapusan riwayat
        // Cek apakah riwayat memiliki data yang relevan
        if ($record->obat_id && $record->jumlah_dipakai) {
            $obat = Obat::find($record->obat_id);

            // Pastikan stok obat tidak kembali bertambah
            if ($obat) {
                // Tidak ada perubahan pada stok obat, hanya memastikan tidak ada penambahan
                // Stok obat tidak bertambah di sini
            }
        }
    }
}
