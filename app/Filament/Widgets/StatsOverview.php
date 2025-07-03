<?php

namespace App\Filament\Widgets;

use App\Models\Balance;
use App\Models\Parcel;
use App\Models\Wallet;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    protected ?string $pollingInterval = null;
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
            'name' => $wallets->name??Action::make('Cadastre uma carteira')
                    ->url(route('filament.admin.resources.wallets.create'))
                    ->color('primary')
                    ->icon('heroicon-o-plus'),
            'saldo' => 'R$ ' . number_format($balance->balance??0, 2, ',', '.')
        ];

        $mesAtual = Carbon::now()->month;
        $anoAtual = Carbon::now()->year;

        $incomesOfMonth = Parcel::join('recurrences', 'recurrences.id', '=', 'parcels.recurrence_id')
            ->join('incomes', 'incomes.id', '=', 'recurrences.income_id')
            ->join('users', 'users.id', '=', 'incomes.user_id')
            ->where('parcels.is_income', true)
            ->where('users.id', $user)
            ->whereMonth('parcels.due_date', $mesAtual)
            ->whereYear('parcels.due_date', $anoAtual)
            ->sum('parcels.amount');
        
        return [
            Stat::make('Carteira', $return['name']),
            Stat::make('Saldo', $return['saldo']),
            Stat::make('Receitas do Mês', 'R$ ' . number_format($incomesOfMonth, 2, ',', '.')),
        ];
    }
}
