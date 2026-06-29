<?php

namespace App\Filament\Widgets;

use App\Models\Wallet;
use Carbon\Carbon;
use Filament\Facades\Filament;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Support\Facades\DB;

class CashFlowChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected ?string $heading = 'Fluxo de caixa (realizado)';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $userId = Filament::auth()->id();
        $walletId = $this->pageFilters['wallet_id'] ?? null;
        $year = Carbon::now()->year;

        $walletIds = Wallet::query()
            ->where('user_id', $userId)
            ->when($walletId, fn ($q) => $q->where('id', $walletId))
            ->pluck('id');

        $rows = DB::table('transactions')
            ->whereIn('wallet_id', $walletIds)
            ->whereYear('occurred_at', $year)
            ->select(
                DB::raw('MONTH(occurred_at) as month_number'),
                'type',
                DB::raw('SUM(amount) as total'),
            )
            ->groupBy(DB::raw('MONTH(occurred_at)'), 'type')
            ->get();

        $income = array_fill(1, 12, 0.0);
        $expense = array_fill(1, 12, 0.0);

        foreach ($rows as $row) {
            if ($row->type === 'income') {
                $income[$row->month_number] = (float) $row->total;
            } else {
                $expense[$row->month_number] = (float) $row->total;
            }
        }

        Carbon::setLocale('pt_BR');
        $labels = [];
        for ($i = 1; $i <= 12; $i++) {
            $labels[] = Carbon::create()->month($i)->translatedFormat('M');
        }

        return [
            'datasets' => [
                [
                    'label' => 'Entradas',
                    'data' => array_values($income),
                    'backgroundColor' => 'rgba(34, 197, 94, 0.2)',
                    'borderColor' => '#22c55e',
                ],
                [
                    'label' => 'Saídas',
                    'data' => array_values($expense),
                    'backgroundColor' => 'rgba(239, 68, 68, 0.2)',
                    'borderColor' => '#ef4444',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
