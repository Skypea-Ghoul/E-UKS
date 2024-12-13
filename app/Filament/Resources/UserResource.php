<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section as ComponentsSection;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Pages\Page;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use function Laravel\Prompts\password;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $label = 'Data Petugas';
    protected static ?string $navigationGroup = 'Menu';
    protected static ?int $navigationSort = 1;

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
                    TextInput::make('name')
                        ->label('Nama')
                        ->required(),
                    Select::make('kelas')
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
                        ->preload()
                        ->searchable()
                        ->required(),
                    Select::make('jenis_kelamin')
                        ->options([
                            'Laki-Laki' => 'Laki-Laki',
                            'Perempuan' => 'Perempuan',
                        ])
                        ->required(),
                    Radio::make('status')
                        ->label('Status Kehadiran')
                        ->options([
                            'Hadir' => 'Hadir',
                            'Tidak Hadir' => 'Tidak Hadir',
                        ])
                        ->reactive()
                        ->afterStateUpdated(fn($state, $set) => $set('keterangan', null)),
                    TextInput::make('email')
                        ->label('Email Address')
                        ->email()
                        ->maxLength(255)
                        ->unique(ignoreRecord: true)
                        ->required(),
                    DateTimePicker::make('email_verified_at')
                        ->label('Email Verified At')
                        ->default(now()),
                    TextInput::make('password')
                        ->label('Password')
                        ->password()
                        ->revealable()
                        ->dehydrated(fn($state) => filled($state))
                        ->required(fn(Page $livewire): bool => $livewire instanceof CreateRecord),
                    TextInput::make('keterangan')
                        ->label('keterangan Tidak Hadir')
                        ->visible(fn($get) => $get('status') === 'Tidak Hadir')
                        ->nullable(),
                ])->columns(2)
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nis')
                    ->label('Nis')
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Nama')
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

                        // Ganti nilai kelas dengan nama kelas
                        return $kelasOptions[$record->kelas] ?? 'Unknown';
                    })
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                TextColumn::make('jenis_kelamin'),
                TextColumn::make('status')
                    ->label('Status Kehadiran')
                    ->badge()
                    ->color(function (string $state): string {
                        return match ($state) {
                            'Tidak Hadir'  => 'danger',
                            'Hadir' => 'success',
                        };
                    })
                    ->sortable(),
                TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('keterangan')
                    ->label('Keterangan Tidak Hadir')
                    ->formatStateUsing(function ($state, $record) {
                        return $record->status === 'Tidak Hadir' ? $state : null;
                    })
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status Kehadiran')
                    ->options([
                        'Hadir' => 'Hadir',
                        'Tidak Hadir' => 'Tidak Hadir',
                    ])
                    ->preload(),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }



    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Info Data Petugas')
                    ->schema([
                        TextEntry::make('nis')
                            ->label('NIS'),
                        TextEntry::make('name')
                            ->label('Nama'),
                        TextEntry::make('kelas')
                            ->label('Kelas')
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
                            }),
                        TextEntry::make('jenis_kelamin')
                            ->label('Jenis Kelamin'),
                        TextEntry::make('status')
                            ->label('Status Kehadiran'),
                        TextEntry::make('keterangan')
                            ->label('Keterangan'),
                    ])->columns(2)
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'edit' => Pages\EditUser::route('/{record}/edit')
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
