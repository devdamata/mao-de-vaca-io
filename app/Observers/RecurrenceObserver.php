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
        $start = Carbon::parse($recurrence->starts_at);
        $end = Carbon::parse($recurrence->ends_at);
        $current = $start->copy();

        $returnAmount = Income::where('id', $recurrence->income_id)->first();
        if ($returnAmount === null) {
            $returnAmount = Expense::where('id', $recurrence->expense_id)->first();
        }

        $isIncome = $recurrence->income_id != null ? true : false;

        while ($current <= $end) {
            Parcel::create([
                'recurrence_id' => $recurrence->id,
                'due_date' => $current->copy(),
                'amount' => $returnAmount->amount,
                'is_income' => $isIncome
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
        $existisParcels = Parcel::where('recurrence_id', $recurrence->income_id)->first();

        if ($existisParcels === null) {
            $start = Carbon::parse($recurrence->starts_at);
            $end = Carbon::parse($recurrence->ends_at);
            $current = $start->copy();

            $returnAmount = Income::where('id', $recurrence->income_id)->first();
            if ($returnAmount === null) {
                $returnAmount = Expense::where('id', $recurrence->expense_id)->first();
            }

            $isIncome = $recurrence->income_id != null ? true : false;
            while ($current <= $end) {
                Parcel::create([
                    'recurrence_id' => $recurrence->id,
                    'due_date' => $current->copy(),
                    'amount' => $returnAmount->amount,
                    'is_income' => $isIncome
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
