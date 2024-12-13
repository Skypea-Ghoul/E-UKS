<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ObatResource\Pages;
use App\Filament\Resources\ObatResource\RelationManagers;
use App\Models\Obat;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Infolists\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Forms\Form;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section as ComponentsSection;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ObatResource extends Resource
{
    protected static ?string $model = Obat::class;

    protected static ?string $navigationIcon = 'heroicon-o-beaker';
    protected static ?string $navigationGroup = 'Menu';
    protected static ?string $navigationLabel = 'Data Obat';
    protected static ?int $navigationSort = 5;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_obat')
                    ->unique(ignoreRecord: true)
                    ->required()
                    ->maxLength(255),
                FileUpload::make('gambar_obat')
                    ->directory('gambar_obat')
                    ->required(),
                Forms\Components\TextInput::make('fungsi_obat')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('jumlah_obat')
                    ->required()
                    ->numeric(),
                Select::make('status_obat')
                    ->options([
                        'Tersedia' => 'Tersedia',
                        'Tidak Tersedia' => 'Tidak Tersedia',
                    ])->default('Tidak Tersedia'),
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
                    ]),
                TextInput::make('anjuran')
                    ->label('Anjuran'),
                TextInput::make('jumlah_dipakai')
                    ->label('Jumlah Dipakai'),
                Select::make('tipe_obat')
                    ->options([
                        'Tablet' => 'Tablet',
                        'Kapsul' => 'Kapsul',
                        'Sirup' => 'Sirup',
                        'Salep/Cream' => 'Salep/Cream',
                        'Tetes' => 'Tetes',
                        'Injeksi' => 'Injeksi',
                        'Suppositoria' => 'Suppositoria',
                        'Inhaler' => 'Inhaler',
                        'Patch' => 'Patch',
                    ])
                    ->label('Tipe Obat'),
                Forms\Components\DatePicker::make('kadaluarsa')
                    ->minDate(now())
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_obat')
                    ->searchable(),
                ImageColumn::make('gambar_obat'),
                TextColumn::make('jenis_obat')
                    ->label('Jenis Obat')
                    ->searchable(),
                Tables\Columns\TextColumn::make('fungsi_obat')
                    ->searchable()
                    ->words(5),
                Tables\Columns\TextColumn::make('jumlah_obat')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('status_obat')
                    ->badge()
                    ->color(function (string $state): string {
                        return match ($state) {
                            'Tidak Tersedia'  => 'danger',
                            'Tersedia' => 'success',
                        };
                    }),
                TextColumn::make('anjuran')
                    ->label('Anjuran')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('jumlah_dipakai')
                    ->label('Jumlah Dipakai')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('tipe_obat')
                    ->label('Tipe Obat')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('kadaluarsa')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('jenis_obat')
                    ->label('Jenis Obat')
                    ->searchable()
                    ->preload()
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
                    ]),
                SelectFilter::make('tipe_obat')
                    ->label('Tipe Obat')
                    ->searchable()
                    ->options([
                        'Tablet' => 'Tablet',
                        'Kapsul' => 'Kapsul',
                        'Sirup' => 'Sirup',
                        'Salep/Cream' => 'Salep/Cream',
                        'Tetes' => 'Tetes',
                        'Injeksi' => 'Injeksi',
                        'Suppositoria' => 'Suppositoria',
                        'Inhaler' => 'Inhaler',
                        'Patch' => 'Patch',
                    ])
                    ->preload(),
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make()
                ]),
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
                Section::make()->schema([
                    TextEntry::make('nama_obat')
                        ->label('Nama Obat'),
                    ImageEntry::make('gambar_obat')
                        ->label('Gambar Obat'),
                    TextEntry::make('fungsi_obat')
                        ->label('Fungsi Obat'),
                    TextEntry::make('jumlah_obat')
                        ->label('Jumlah Obat'),
                    TextEntry::make('status_obat')
                        ->label('Status Obat'),
                    TextEntry::make('anjuran')
                        ->label('Anjuran Obat'),
                    TextEntry::make('jumlah_dipakai')
                        ->label('Jumlah Dipakai'),
                    TextEntry::make('anjuran')
                        ->label('Anjuran Obat'),
                    TextEntry::make('tipe_obat')
                        ->label('Tipe Obat'),
                    TextEntry::make('jenis_obat')
                        ->label('Jenis Obat'),
                    TextEntry::make('kadaluarsa')
                        ->label('Tanggal Kadaluarsa'),
                ])->columns(2)

            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageObats::route('/'),
        ];
    }


    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (isset($data['jumlah_dipakai']) && $data['jumlah_dipakai'] > 0) {
            // Kurangi jumlah obat dengan jumlah yang dipakai
            $data['jumlah_obat'] -= $data['jumlah_dipakai'];
            // Pastikan jumlah obat tidak negatif
            $data['jumlah_obat'] = max($data['jumlah_obat'], 0);
        }

        return $data;
    }
}
