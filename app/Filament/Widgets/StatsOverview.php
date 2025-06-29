<?php

namespace App\Filament\Widgets;

use App\Models\Balance;
use App\Models\Parcel;
use App\Models\Wallet;
use Carbon\Carbon;
use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    protected static ?string $pollingInterval = null;
    protected static bool $isLazy = false;
    protected function getStats(): array
    {
        $user = Filament::auth()->user()->id;

        $wallets = Wallet::with('user')
            ->where('user_id', $user)
            ->first();

        if ($wallets != null) {
            $balance = Balance::where('wallet_id', $wallets->id)
            ->first();
        }

        $return = [
            'name' => $wallets->name??'Cadastre uma carteira',
            'saldo' => 'R$ ' . number_format($balance->balance??0, 2, ',', '.')
        ];

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

        return [
            Stat::make('Carteira', $return['name']),
            Stat::make('Saldo', $return['saldo']),
            Stat::make('Receitas do Mês', 'R$ ' . number_format($incomesOfMonth, 2, ',', '.')),
        ];
    }
}
