<?php

namespace App\Filament\Widgets;

use App\Models\Faktur;
use App\Models\Customer;
use App\Models\Barang;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsDashboard extends BaseWidget
{
    protected function getStats(): array
    {
        $countFaktur = Faktur::count();
        $countCustomer = Customer::count();
        $countBarang = Barang::count();
        return [
            Stat::make(label: 'Jumlah Faktur', value: $countFaktur . ' Faktur'),
            Stat::make(label: 'Jumlah Customer', value: $countCustomer . ' Customer'),
            Stat::make(label: 'Jumlah Barang', value: $countBarang . ' Barang'),
        ];
    }
}
