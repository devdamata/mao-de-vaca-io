<?php

namespace App\Filament\Widgets;

use App\Models\Wallet;
use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    protected function getStats(): array
    {
        $user = Filament::auth()->user()->id;

        $wallets = Wallet::with('user')
            ->where('user_id', $user)
            ->get();
        $return = [];
        foreach ($wallets as $wallet) {
            $return = [
                'name' => $wallet->name,
                'saldo' => 'R$ ' . number_format($wallet->initial_balance, 2, ',', '.')
            ];
        }

        return [
            Stat::make('Carteira', $return['name']),
            Stat::make('Saldo', $return['saldo']),
//            Stat::make('Average time on page', '3:12'),
        ];
    }
}
