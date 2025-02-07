<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FakturResource\Pages;
use App\Filament\Resources\FakturResource\RelationManagers;
use App\Models\Faktur;
use App\Models\Customer;
use App\Models\Barang;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Get;
use Filament\Forms\Set;

class FakturResource extends Resource
{
    protected static ?string $model = Faktur::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Laporan Penjualan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                TextInput::make('kode_faktur')
                    ->label('Kode Faktur')
                    ->columnSpan([
                        'default' => 2,
                        'md' => 1,
                        'lg' => 1,
                        'xl' => 1,
                    ])
                    ->required(),

                Select::make('customer_id')
                    ->columnSpan([
                        'default' => 2,
                        'md' => 1,
                        'lg' => 1,
                        'xl' => 1,
                    ])
                    ->relationship(name: 'customer', titleAttribute: 'name')
                    ->label('Nama Customer')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $customer = Customer::find($state);

                        if ($customer) {
                            $set('kode_customer', $customer->kode_customer);
                        }
                    }),
                TextInput::make('kode_customer')
                    ->readOnly()
                    ->columnSpan([
                        'default' => 2,
                        'md' => 1,
                        'lg' => 1,
                        'xl' => 1,
                    ])
                    ->label('Kode Customer')
                    ->required(),
                DatePicker::make('tanggal_faktur')
                    ->columnSpan([
                        'default' => 2,
                        'md' => 1,
                        'lg' => 1,
                        'xl' => 1,
                    ])
                    ->label('Tanggal Faktur')
                    ->required(),


                Repeater::make('detail')
                    ->relationship()
                    ->schema([
                        // ...
                        Select::make('barang_id')
                            ->relationship(name: 'barang', titleAttribute: 'nama_barang')
                            ->label('Barang')
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                $barang = Barang::find($state);

                                if ($barang) {
                                    $set('harga', $barang->harga_barang);
                                    $set('nama_barang', $barang->nama_barang);
                                }
                            }),

                        TextInput::make('nama_barang')
                            ->label('Nama Barang')
                            ->readonly()
                            ->required(),
                        TextInput::make('harga')
                            ->prefix('Rp')
                            ->label('Harga')
                            ->numeric()
                            ->required(),
                        TextInput::make('qty')
                            ->numeric()
                            ->label('Qty')
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function (Set $set, $state, Get $get) {
                                $tampungHarga = $get('harga');
                                $set('hasil_qty', intval($state * $tampungHarga));
                            }),
                        TextInput::make('hasil_qty')
                            ->numeric()
                            ->label('Hasil Qty'),
                        TextInput::make('diskon')
                            ->numeric()
                            ->reactive()
                            ->live()
                            ->afterStateUpdated(function (Set $set, $state, Get $get) {
                                $hasilQTY = $get('hasil_qty');
                                $diskon = $hasilQTY * ($state / 100);
                                $hasil = $hasilQTY - $diskon;

                                $set('subtotal', intval($hasil));
                            }),
                        TextInput::make('subtotal')
                            ->label('Subtotal')
                            ->numeric()

                    ])
                    ->columnSpan(2),
                Textarea::make('ket_faktur')
                    ->label('keterangan faktur')
                    ->columnSpan(2),

                TextInput::make('nominal_charge')
                    ->columnSpan([
                        'default' => 2,
                        'md' => 1,
                        'lg' => 1,
                        'xl' => 1,
                    ])
                    ->columnSpan(2)
                    ->label('Nominal Charge')
                    ->reactive()
                    ->afterStateUpdated(function (Set $set, $state, Get $get) {
                        $total = $get('total');
                        $charge = $total * ($state / 100);
                        $hasil = $total + $charge;

                        $set('total_final', $hasil);
                        $set('charge', $charge);
                    })
                    ->required(),
                TextInput::make('charge')
                    ->columnSpan([
                        'default' => 2,
                        'md' => 1,
                        'lg' => 1,
                        'xl' => 1,
                    ])
                    ->columnSpan(2)
                    ->label('Charge')
                    ->required(),
                TextInput::make('total')
                    ->columnSpan([
                        'default' => 2,
                        'md' => 1,
                        'lg' => 1,
                        'xl' => 1,
                    ])
                    ->label('Total')
                    ->columnSpan(2)
                    ->required()
                    ->placeholder(function (Set $set, Get $get) {
                        $detail = collect($get('detail'))->pluck('subtotal')->sum();
                        if ($detail == null) {
                            $set('total', 0);
                        } else {
                            $set('total', $detail);
                        }
                    }),
                TextInput::make('total_final')
                    ->columnSpan([
                        'default' => 2,
                        'md' => 1,
                        'lg' => 1,
                        'xl' => 1,
                    ])
                    ->columnSpan(2)
                    ->label('Total Final')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('kode_faktur'),
                TextColumn::make('tanggal_faktur'),
                TextColumn::make('kode_customer'),
                TextColumn::make('customer.name'),
                TextColumn::make('ket_faktur'),
                TextColumn::make('total')
                    ->formatStateUsing(fn(Faktur $record): string => 'Rp ' . number_format($record->total, 0, ',', '.')),
                TextColumn::make('nominal_charge'),
                TextColumn::make('charge'),
                TextColumn::make('total_final'),
            ])
            ->emptyStateHeading('Tidak ada Data Faktur')
            ->emptyStateDescription('Silahkan Tambah Faktur Terlebih Dahulu.')
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListFakturs::route('/'),
            'create' => Pages\CreateFaktur::route('/create'),
            'edit' => Pages\EditFaktur::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
