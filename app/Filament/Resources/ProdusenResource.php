<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProdusenResource\Pages;
use App\Filament\Resources\ProdusenResource\RelationManagers;
use App\Models\Produsen;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;

class ProdusenResource extends Resource
{
    protected static ?string $model = Produsen::class;

    protected static ?string $navigationIcon = 'heroicon-o-home-modern';
    protected static ?string $navigationLabel = 'Produsen';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                TextInput::make('nama_produsen')
                    ->required()
                    ->label('Nama Produsen')
                    ->placeholder('Masukkan Nama Produsen'),
                TextInput::make('kode_produsen')
                    ->required()
                    ->label('Kode Produsen')
                    ->placeholder('Masukkan Kode Produsen'),
                TextInput::make('alamat_produsen')
                    ->required()
                    ->label('Alamat Produsen')
                    ->placeholder('Masukkan Alamat Produsen'),
                TextInput::make('no_telp_produsen')
                    ->required()
                    ->numeric()
                    ->label('No. Telp Produsen')
                    ->placeholder('Masukkan No. Telp Produsen'),
                TextInput::make('email_produsen')
                    ->required()
                    ->email()
                    ->label('Email Produsen')
                    ->placeholder('Masukkan Email Produsen'),
                TextInput::make('jenis_produk')
                    ->required()
                    ->label('Jenis Produk')
                    ->placeholder('Masukkan Jenis Produk'),
                TextInput::make('deskripsi')
                    ->required()
                    ->label('Deskripsi')
                    ->placeholder('Masukkan Deskripsi'),
                TextInput::make('status')
                    ->required()
                    ->label('Status')
                    ->placeholder('Masukkan Status'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('nama_produsen')
                    ->label('Nama Produsen')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('kode_produsen')
                    ->label('Kode Produsen')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Kode copied'),
                TextColumn::make('alamat_produsen')
                    ->label('Alamat Produsen')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Alamat copied'),
                TextColumn::make('no_telp_produsen')
                    ->label('No. Telp Produsen')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('No. Telp copied'),
                TextColumn::make('email_produsen')
                    ->label('Email Produsen')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Email copied'),
                TextColumn::make('jenis_produk')
                    ->label('Jenis Produk')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('deskripsi')
                    ->label('Deskripsi')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->searchable()
                    ->sortable(),
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
            'index' => Pages\ListProdusens::route('/'),
            'create' => Pages\CreateProdusen::route('/create'),
            'edit' => Pages\EditProdusen::route('/{record}/edit'),
        ];
    }
}
