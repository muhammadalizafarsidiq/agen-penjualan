<?php

namespace App\Filament\Resources\ProdusenResource\Pages;

use App\Filament\Resources\ProdusenResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProdusen extends EditRecord
{
    protected static string $resource = ProdusenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
