<?php

namespace App\Filament\Pages;

use App\Models\Wallet;
use Filament\Facades\Filament;
use Filament\Forms\Components\Select;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Schemas\Schema;

class Dashboard extends BaseDashboard
{
    use HasFiltersForm;

    public function filtersForm(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('wallet_id')
                    ->label('Carteira')
                    ->placeholder('Todas as carteiras')
                    ->options(fn (): array => Wallet::query()
                        ->where('user_id', Filament::auth()->id())
                        ->pluck('name', 'id')
                        ->all())
                    ->native(false),
            ]);
    }
}
