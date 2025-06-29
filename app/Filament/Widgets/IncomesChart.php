<?php

namespace App\Filament\Widgets;

use App\Models\Income;
use App\Models\Parcel;
use Carbon\Carbon;
use Filament\Facades\Filament;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class IncomesChart extends ChartWidget
{
    protected ?string $heading = 'Receitas do Ano';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $data = $this->getStatsIncomes();

        $map = $data->keyBy('month_number');

        $labels = [];
        $values = [];

        Carbon::setLocale('pt_BR');

        for ($i = 1; $i <= 12; $i++) {
            $labels[] = Carbon::create()->month($i)->translatedFormat('F');

            if ($map->has($i)) {
                $values[] = (float) $map[$i]->total;
            } else {
                $values[] = 0;
            }
        }

        return [
            'datasets' => [
                [
                    'label' => 'Receitas',
                    'data' => $values,
                    'backgroundColor' => '#4CAF50',
                ],
            ],
            'labels' => $labels,
        ];
    }
    protected function getType(): string
    {
        return 'line';
    }

    public function getStatsIncomes()
    {
        $user = Filament::auth()->user()->id;

        $result = DB::table('parcels')
            ->join('recurrences', 'parcels.recurrence_id', '=', 'recurrences.id')
            ->join('incomes', 'recurrences.income_id', '=', 'incomes.id')
            ->where('parcels.is_income', true)
            ->where('incomes.user_id', $user)
            ->whereYear('parcels.due_date', 2025)
            ->select(
                DB::raw('MONTH(parcels.due_date) as month_number'),
                DB::raw('MONTHNAME(parcels.due_date) as month_name'),
                DB::raw('SUM(parcels.amount) as total')
            )
            ->groupBy(DB::raw('MONTH(parcels.due_date)'), DB::raw('MONTHNAME(parcels.due_date)'))
            ->orderBy(DB::raw('MONTH(parcels.due_date)'))
            ->get();

        return $result;
    }
}
