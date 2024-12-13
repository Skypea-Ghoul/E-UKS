<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DokterResource\Pages;
use App\Models\Dokter;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\Section;
use Filament\Forms\Components\DateTimePicker;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Illuminate\Database\Eloquent\Builder;

class DokterResource extends Resource
{
    protected static ?string $model = Dokter::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $label = 'Jadwal Dokter';
    protected static ?string $navigationGroup = 'Menu';
    protected static ?int $navigationSort = 7;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama_dokter')
                    ->required()
                    ->maxLength(255),
                TextInput::make('spesialis')
                    ->required()
                    ->maxLength(255),
                DateTimePicker::make('jam_masuk')
                    ->label('Jam Masuk')
                    ->required()
                    ->timezone('Asia/Jakarta')
                    ->displayFormat('H:i'),
                DateTimePicker::make('jam_keluar')
                    ->label('Jam Keluar')
                    ->required()
                    ->timezone('Asia/Jakarta')
                    ->displayFormat('H:i'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_dokter')
                    ->searchable(),
                TextColumn::make('spesialis')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jam_masuk')
                    ->dateTime('H:i', 'Asia/Jakarta')
                    ->label('Jam Masuk'),
                Tables\Columns\TextColumn::make('jam_keluar')
                    ->dateTime('H:i', 'Asia/Jakarta')
                    ->label('Jam Keluar'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Info Jadwal Dokter')
                    ->schema([
                        TextEntry::make('nama_dokter')
                            ->label('Nama Dokter'),
                        TextEntry::make('spesialis')
                            ->label('Spesialis'),
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
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDokters::route('/'),
            'create' => Pages\CreateDokter::route('/create'),
            'edit' => Pages\EditDokter::route('/{record}/edit'),
        ];
    }
}
