<?php

namespace App\Filament\Resources\WalletResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\WalletResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWallets extends ListRecords
{
    protected static string $resource = WalletResource::class;
    protected static ?string $title = 'Carteiras';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
