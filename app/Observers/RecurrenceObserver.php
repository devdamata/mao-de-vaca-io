<?php

namespace App\Observers;

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
        $start = Carbon::parse($recurrence->starts_at);
        $end = Carbon::parse($recurrence->ends_at);
        $current = $start->copy();

        $income = Income::where('id', $recurrence->income_id)->first();

        while ($current <= $end) {
            Parcel::create([
                'recurrence_id' => $recurrence->id,
                'due_date' => $current->copy(),
                'amount' => $income->amount,
                'is_income' => (bool)$recurrence->id,
            ]);

            switch ($recurrence->frequency) {
                case 'monthly':
                    $current->addMonth();
                    break;
                case 'weekly':
                    $current->addWeek();
                    break;
                case 'daily':
                    $current->addDay();
                    break;
                case 'yearly':
                    $current->addYear();
                    break;
                default:
                    $current = $end->copy()->addDay();
                    break;
            }
        }
    }

    /**
     * Handle the Recurrence "updated" event.
     */
    public function updated(Recurrence $recurrence): void
    {
        //
    }

    /**
     * Handle the Recurrence "deleted" event.
     */
    public function deleted(Recurrence $recurrence): void
    {
        //
    }

    /**
     * Handle the Recurrence "restored" event.
     */
    public function restored(Recurrence $recurrence): void
    {
        //
    }

    /**
     * Handle the Recurrence "force deleted" event.
     */
    public function forceDeleted(Recurrence $recurrence): void
    {
        //
    }
}
