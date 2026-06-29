<?php

namespace App\Observers;

use App\Models\Expense;
use App\Models\Income;
use App\Models\Recurrence;
use App\Models\Parcel;
use Carbon\Carbon;

class RecurrenceObserver
{
    /**
     * Handle the Recurrence "created" event.
     */
    public function created(Recurrence $recurrence): void
    {
        $this->generateParcels($recurrence);
    }

    /**
     * Handle the Recurrence "updated" event.
     */
    public function updated(Recurrence $recurrence): void
    {
        // Regenera as parcelas apenas quando a frequência ou as datas mudam
        if ($recurrence->wasChanged(['frequency', 'starts_at', 'ends_at', 'income_id', 'expense_id'])) {
            $recurrence->parcel()->delete();
            $this->generateParcels($recurrence);
        }
    }

    /**
     * Gera as parcelas de uma recorrência entre starts_at e ends_at.
     */
    private function generateParcels(Recurrence $recurrence): void
    {
        if (! $recurrence->starts_at || ! $recurrence->ends_at) {
            return;
        }

        $source = $recurrence->income_id
            ? Income::find($recurrence->income_id)
            : Expense::find($recurrence->expense_id);

        if (! $source) {
            return;
        }

        $isIncome = $recurrence->income_id !== null;

        $current = Carbon::parse($recurrence->starts_at);
        $end = Carbon::parse($recurrence->ends_at);

        while ($current <= $end) {
            Parcel::create([
                'recurrence_id' => $recurrence->id,
                'due_date' => $current->copy(),
                'amount' => $source->amount,
                'is_income' => $isIncome,
            ]);

            match ($recurrence->frequency) {
                'monthly' => $current->addMonth(),
                'weekly'  => $current->addWeek(),
                'daily'   => $current->addDay(),
                'yearly'  => $current->addYear(),
                // 'once' (ou desconhecido): encerra após uma única parcela
                default   => $current = $end->copy()->addDay(),
            };
        }
    }
}
