<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BarangResource\Pages;
use App\Filament\Resources\BarangResource\RelationManagers;
use App\Models\Barang;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;


class BarangResource extends Resource
{
    protected static ?string $model = Barang::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationLabel = 'Barang';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                TextInput::make('nama_barang')
                    ->required()
                    ->label('Nama Barang')
                    ->placeholder('Masukkan Nama Barang')
                    ->columnSpan(2),
                TextInput::make('kode_barang')
                    ->required()
                    ->label('Kode Barang')
                    ->placeholder('Masukkan Kode Barang')
                    ->columnSpan(2),
                TextInput::make('harga_barang')
                    ->required()
                    ->numeric()
                    ->label('Harga Barang')
                    ->placeholder('Masukkan Harga Barang')
                    ->columnSpan(2),
                TextInput::make('stok_barang')
                    ->required()
                    ->numeric()
                    ->label('Stok Barang')
                    ->placeholder('Masukkan Stok Barang')
                    ->columnSpan(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('kode_barang')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Kode berhasil disalin'),
                TextColumn::make('nama_barang')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('harga_barang')
                    ->sortable(),
                TextColumn::make('stok_barang')
                    ->sortable(),
                TextColumn::make('created_at'),
            ])
            ->emptyStateHeading('Tidak ada Data Barang')
            ->emptyStateDescription('Silahkan Tambah Barang Terlebih Dahulu.')
            ->filters([
                //
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBarangs::route('/'),
            'create' => Pages\CreateBarang::route('/create'),
            'edit' => Pages\EditBarang::route('/{record}/edit'),
        ];
    }
}
