<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use Filament\Facades\Filament;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Support\Facades\DB;

class ExpensesByCategoryChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected ?string $heading = 'Gastos por categoria (mês)';

    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $userId = Filament::auth()->id();
        $walletId = $this->pageFilters['wallet_id'] ?? null;

        $rows = DB::table('parcels')
            ->join('recurrences', 'recurrences.id', '=', 'parcels.recurrence_id')
            ->join('expenses', 'expenses.id', '=', 'recurrences.expense_id')
            ->leftJoin('expense_categories', 'expense_categories.id', '=', 'expenses.expense_category_id')
            ->where('expenses.user_id', $userId)
            ->when($walletId, fn ($q) => $q->where('expenses.wallet_id', $walletId))
            ->whereMonth('parcels.due_date', Carbon::now()->month)
            ->whereYear('parcels.due_date', Carbon::now()->year)
            ->groupBy('expense_categories.name')
            ->select(
                DB::raw('COALESCE(expense_categories.name, \'Sem categoria\') as label'),
                DB::raw('SUM(parcels.amount) as total'),
            )
            ->orderByDesc('total')
            ->get();

        $palette = ['#ef4444', '#f97316', '#eab308', '#22c55e', '#3b82f6', '#8b5cf6', '#ec4899', '#14b8a6', '#64748b'];

        return [
            'datasets' => [
                [
                    'label' => 'Gastos',
                    'data' => $rows->pluck('total')->map(fn ($v) => (float) $v)->all(),
                    'backgroundColor' => $rows->keys()->map(fn ($i) => $palette[$i % count($palette)])->all(),
                ],
            ],
            'labels' => $rows->pluck('label')->all(),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
