<?php

namespace App\Filament\Widgets;

use App\Models\Parcel;
use App\Models\Wallet;
use Carbon\Carbon;
use Filament\Facades\Filament;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Builder;

class StatsOverview extends BaseWidget
{
    use InteractsWithPageFilters;

    protected static ?int $sort = 1;

    protected ?string $pollingInterval = null;

    protected static bool $isLazy = false;

    protected function getStats(): array
    {
        $userId = Filament::auth()->id();
        $walletId = filled($this->pageFilters['wallet_id'] ?? null)
            ? (int) $this->pageFilters['wallet_id']
            : null;

        $mes = Carbon::now()->month;
        $ano = Carbon::now()->year;

        $wallets = Wallet::query()
            ->where('user_id', $userId)
            ->when($walletId, fn (Builder $q) => $q->where('id', $walletId))
            ->get();

        $saldoAtual = (float) $wallets->sum(fn (Wallet $wallet) => $wallet->currentBalance());

        $parcelasDoMes = $this->scopedParcels($userId, $walletId)
            ->whereMonth('due_date', $mes)
            ->whereYear('due_date', $ano);

        $receitasMes = (float) (clone $parcelasDoMes)->where('is_income', true)->sum('amount');
        $despesasMes = (float) (clone $parcelasDoMes)->where('is_income', false)->sum('amount');

        $aReceber = (float) (clone $parcelasDoMes)->where('is_income', true)->where('is_paid', false)->sum('amount');
        $aPagar = (float) (clone $parcelasDoMes)->where('is_income', false)->where('is_paid', false)->sum('amount');

        $saldoProjetado = $saldoAtual + $aReceber - $aPagar;

        return [
            Stat::make('Saldo atual', $this->money($saldoAtual))
                ->description($wallets->count() === 1 ? $wallets->first()->name : 'Todas as carteiras')
                ->color($saldoAtual < 0 ? 'danger' : 'success'),
            Stat::make('Saldo projetado (fim do mês)', $this->money($saldoProjetado))
                ->description('Após receber e pagar o que está em aberto')
                ->color($saldoProjetado < 0 ? 'danger' : 'success'),
            Stat::make('Receitas do mês', $this->money($receitasMes))
                ->description($this->money($aReceber).' ainda a receber')
                ->color('success'),
            Stat::make('Despesas do mês', $this->money($despesasMes))
                ->description($this->money($aPagar).' ainda a pagar')
                ->color('danger'),
        ];
    }

    private function scopedParcels(int $userId, ?int $walletId): Builder
    {
        return Parcel::query()->whereHas('recurrence', function (Builder $query) use ($userId, $walletId) {
            $query->whereHas('income', function (Builder $income) use ($userId, $walletId) {
                $income->where('user_id', $userId)
                    ->when($walletId, fn (Builder $q) => $q->where('wallet_id', $walletId));
            })->orWhereHas('expenses', function (Builder $expense) use ($userId, $walletId) {
                $expense->where('user_id', $userId)
                    ->when($walletId, fn (Builder $q) => $q->where('wallet_id', $walletId));
            });
        });
    }

    private function money(float $value): string
    {
        return 'R$ '.number_format($value, 2, ',', '.');
    }
}
