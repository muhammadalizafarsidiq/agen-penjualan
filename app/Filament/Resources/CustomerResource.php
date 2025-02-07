<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';
    protected static ?string $navigationLabel = 'Customer';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                TextInput::make('name')
                    ->required()
                    ->label('Name')
                    ->placeholder('Masukan Nama')
                    ->columnSpan(2),
                TextInput::make('kode_customer')
                    ->required()
                    ->label('Kode Customer')
                    ->placeholder('Masukan Kode Customer')
                    ->columnSpan(2),
                TextInput::make('email')
                    ->required()
                    ->email()
                    ->label('Email')
                    ->placeholder('Masukan Email')
                    ->columnSpan(2),
                TextInput::make('phone_number')
                    ->required()
                    ->label('Phone Number')
                    ->placeholder('Masukan Nomor Telepon')
                    ->columnSpan(2),
                TextInput::make('address')
                    ->required()
                    ->label('Address')
                    ->placeholder('Masukan Alamat')
                    ->columnSpan(2),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('kode_customer')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Kode berhasil disalin'),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->sortable(),
                TextColumn::make('phone_number')
                    ->sortable(),
                TextColumn::make('address')
                    ->sortable(),
                TextColumn::make('created_at'),
            ])
            ->emptyStateHeading('Tidak ada Data customer')
            ->emptyStateDescription('Silahkan Tambah Customer Terlebih Dahulu.')
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
