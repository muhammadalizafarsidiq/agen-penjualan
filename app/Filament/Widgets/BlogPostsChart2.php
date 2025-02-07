<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Faktur;
use App\Models\Customer;
use App\Models\Barang;

class BlogPostsChart2 extends ChartWidget
{
    protected static ?string $heading = 'Distribusi Data';

    protected function getData(): array
    {
        // Hitung jumlah data di setiap tabel
        $countFaktur = Faktur::count();
        $countCustomer = Customer::count();
        $countBarang = Barang::count();

        return [
            'datasets' => [
                [
                    'data' => [$countFaktur, $countCustomer, $countBarang], // Data untuk pie chart
                    'backgroundColor' => ['#FF6384', '#36A2EB', '#FFCE56'], // Warna untuk tiap kategori
                ],
            ],
            'labels' => ['Faktur', 'Customer', 'Barang'], // Label untuk kategori
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
