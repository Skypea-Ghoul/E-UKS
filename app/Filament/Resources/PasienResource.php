<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PasienResource\Pages;
use App\Filament\Resources\PasienResource\RelationManagers;
use App\Models\Pasien;
use DateTime;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Infolists\Infolist;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Infolists\Components\TextEntry;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Infolists\Components\ImageEntry;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\Features\SupportConsoleCommands\Commands\MakeCommand;

class PasienResource extends Resource
{
    protected static ?string $model = Pasien::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $label = 'Data Pasien';
    protected static ?string $navigationGroup = 'Menu';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()->schema([
                    TextInput::make('nis')
                        ->label('Nis')
                        ->disabledOn('edit')
                        ->unique(ignoreRecord: true)
                        ->required(),
                    TextInput::make('nama')
                        ->label('Nama')
                        ->required(),
                    Select::make('kelas')
                        ->options([
                            'X-AKL 1',
                            'X-AKL 2',
                            'X-AKL 3',
                            'X-MP 1',
                            'X-MP 2',
                            'X-BR 1',
                            'X-BR 2',
                            'X BD',
                            'X-ULW',
                            'X-RPL',
                            'XI-AKL 1',
                            'XI-AKL 2',
                            'XI-AKL 3',
                            'XI-MP 1',
                            'XI-MP 2',
                            'XI-BR 1',
                            'XI-BR 2',
                            'XI-BD',
                            'XI-ULW',
                            'XI-RPL',
                            'XII-AKL 1',
                            'XII-AKL 2',
                            'XII-AKL 3',
                            'XII-MP 1',
                            'XII-MP 2',
                            'XII-MP 3',
                            'XII-BR 1',
                            'XII-BR 2',
                            'XII-BD',
                            'XII-ULW'
                        ])
                        ->preload()
                        ->searchable()
                        ->required(),
                    FileUpload::make('gambar')
                        ->directory('gambar')
                        ->required('Gambar pasien wajib diupload.'),
                    DatePicker::make('tanggal_lahir')
                        ->maxDate(now())
                        ->required('Tanggal lahir wajib diisi.'),
                    Select::make('jenis_kelamin')
                        ->options([
                            'Laki-Laki' => 'Laki-Laki',
                            'Perempuan' => 'Perempuan',
                        ]),
                    TextInput::make('jumlah_pendaftaran')
                        ->label('Jumlah Pendaftaran')
                        ->required('Jumlah pendaftaran wajib diisi.')
                        ->numeric()
                        ->default(1)
                        ->minValue(1)
                        ->maxValue(3),
                ])->columns(2)
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nis')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('nama')
                    ->searchable(),
                TextColumn::make('kelas')
                    ->getStateUsing(function ($record) {
                        $kelasOptions = [
                            'X-AKL 1',
                            'X-AKL 2',
                            'X-AKL 3',
                            'X-MP 1',
                            'X-MP 2',
                            'X-BR 1',
                            'X-BR 2',
                            'X-BD',
                            'X-ULW',
                            'X-RPL',
                            'XI-AKL 1',
                            'XI-AKL 2',
                            'XI-AKL 3',
                            'XI-MP 1',
                            'XI-MP 2',
                            'XI-BR 1',
                            'XI-BR 2',
                            'XI-BD',
                            'XI-ULW',
                            'XI-RPL',
                            'XII-AKL 1',
                            'XII-AKL 2',
                            'XII-AKL 3',
                            'XII-MP 1',
                            'XII-MP 2',
                            'XII-MP 3',
                            'XII-BR 1',
                            'XII-BR 2',
                            'XII-BD',
                            'XII-ULW'
                        ];

                        return $kelasOptions[$record->kelas] ?? 'Unknown';
                    })
                    ->searchable(),
                ImageColumn::make('gambar'),
                TextColumn::make('tanggal_lahir'),
                TextColumn::make('jenis_kelamin'),
                TextColumn::make('created_at')
                    ->dateTime('d F Y', 'Asia/Jakarta')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Tanggal Dibuat'),
                TextColumn::make('jumlah_pendaftaran')
                    ->label('Jumlah Pendaftaran'),
            ])
            ->filters([
                SelectFilter::make('jenis_kelamin')
                    ->label('Jenis Kelamin')
                    ->options([
                        'Laki-Laki' => 'Laki-Laki',
                        'Perempuan' => 'Perempuan',
                    ])
                    ->searchable(),
                SelectFilter::make('kelas')
                    ->label('Kelas')
                    ->options([
                        'X-AKL 1',
                        'X-AKL 2',
                        'X-AKL 3',
                        'X-MP 1',
                        'X-MP 2',
                        'X-BR 1',
                        'X-BR 2',
                        'X BD',
                        'X-ULW',
                        'X-RPL',
                        'XI-AKL 1',
                        'XI-AKL 2',
                        'XI-AKL 3',
                        'XI-MP 1',
                        'XI-MP 2',
                        'XI-BR 1',
                        'XI-BR 2',
                        'XI-BD',
                        'XI-ULW',
                        'XI-RPL',
                        'XII-AKL 1',
                        'XII-AKL 2',
                        'XII-AKL 3',
                        'XII-MP 1',
                        'XII-MP 2',
                        'XII-MP 3',
                        'XII-BR 1',
                        'XII-BR 2',
                        'XII-BD',
                        'XII-ULW'
                    ])
                    ->searchable()
                    ->preload(),
                SelectFilter::make('jumlah_pendaftaran')
                    ->options([
                        '1' => '1',
                        '2' => '2',
                        '3' => '3',
                    ])
                    ->label('Jumlah Pendaftaran')
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),


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
                Section::make('Info Data Pasien')
                    ->schema([
                        TextEntry::make('nis')
                            ->label('NIS'),
                        TextEntry::make('nama'),
                        TextEntry::make('kelas')
                            ->getStateUsing(function ($record) {
                                $kelasOptions = [
                                    'X-AKL 1',
                                    'X-AKL 2',
                                    'X-AKL 3',
                                    'X-MP 1',
                                    'X-MP 2',
                                    'X-BR 1',
                                    'X-BR 2',
                                    'X-BD',
                                    'X-ULW',
                                    'X-RPL',
                                    'XI-AKL 1',
                                    'XI-AKL 2',
                                    'XI-AKL 3',
                                    'XI-MP 1',
                                    'XI-MP 2',
                                    'XI-BR 1',
                                    'XI-BR 2',
                                    'XI-BD',
                                    'XI-ULW',
                                    'XI-RPL',
                                    'XII-AKL 1',
                                    'XII-AKL 2',
                                    'XII-AKL 3',
                                    'XII-MP 1',
                                    'XII-MP 2',
                                    'XII-MP 3',
                                    'XII-BR 1',
                                    'XII-BR 2',
                                    'XII-BD',
                                    'XII-ULW'
                                ];

                                // Ganti nilai kelas dengan nama kelas
                                return $kelasOptions[$record->kelas] ?? 'Unknown';
                            }),
                        ImageEntry::make('gambar'),
                        TextEntry::make('tanggal_lahir'),
                        TextEntry::make('jenis_kelamin'),
                    ])->columns(2)
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPasiens::route('/'),
            // 'create' => Pages\CreatePasien::route('/create'),
            // 'edit' => Pages\EditPasien::route('/{record}/edit'),
        ];
    }
}
