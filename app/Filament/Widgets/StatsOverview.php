<?php

namespace App\Filament\Widgets;

use App\Models\Parcel;
use App\Models\Wallet;
use Carbon\Carbon;
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

        $mesAtual = Carbon::now()->month;
        $anoAtual = Carbon::now()->year;
        $incomesOfMonth = Parcel::
            with('recurrence')
            ->with('income')
            ->with('user')
            ->where('is_income', true)
            ->whereMonth('due_date', $mesAtual)
            ->whereYear('due_date', $anoAtual)
            ->sum('amount');
//        $incomesOfMonth = Parcel::whereMonth('due_date', $mesAtual)->whereYear('data', $anoAtual)->sum('valor');


        return [
            Stat::make('Carteira', $return['name']),
            Stat::make('Saldo', $return['saldo']),
            Stat::make('Receitas do Mês', 'R$ ' . number_format($incomesOfMonth, 2, ',', '.')),
        ];
    }
}
