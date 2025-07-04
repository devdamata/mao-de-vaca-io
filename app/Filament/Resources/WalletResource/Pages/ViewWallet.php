<?php

namespace App\Filament\Resources\WalletResource\Pages;

use Filament\Actions\EditAction;
use App\Filament\Resources\WalletResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewWallet extends ViewRecord
{
    protected static string $resource = WalletResource::class;
    protected static ?string $title = 'Ver Carteira';

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
