<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Parcel extends Model
{
    protected $fillable = [
        'recurrence_id',
        'due_date',
        'amount',
        'is_income',
        'is_paid'
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'amount' => 'decimal:2',
    ];

    public function recurrence()
    {
        return $this->belongsTo(Recurrence::class, 'recurrence_id');
    }

    public function income()
    {
        return $this->belongsTo(Income::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted(): void
    {
        static::saved(function ($parcel) {
            // Só recalcula se o campo 'paid' mudou
            if ($parcel->isDirty('is_paid')) {
                $parcel->updateMonthlyBalance();
            }
        });
    }

    public function updateMonthlyBalance(): void
    {
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;

        $walletId = $this->recurrence->expenses->wallet_id;

        $balanceInitial = Wallet::where('id', $walletId)
            ->first();

        $totalPaid = Parcel::with('recurrence')->with('expenses')
            ->whereHas('recurrence', function ($query) use ($month, $year) {
                $query->whereMonth('starts_at', $month)
                    ->whereYear('starts_at', $year);
            })
            ->where('is_paid', true)
            ->where('is_paid', true)
            ->sum('amount');

        $totalReceived = Parcel::with('recurrence')->with('income')
            ->whereHas('recurrence', function ($query) use ($month, $year) {
                $query->whereMonth('starts_at', $month)
                    ->whereYear('starts_at', $year);
            })
            ->where('is_income', true)
            ->where('is_paid', true)
            ->sum('amount');

        $balanceInitial = ($balanceInitial->initial_balance - $totalPaid) + $totalReceived;
        Balance::updateOrCreate(
            [
                'wallet_id' => $walletId,
                'month' => $month,
                'year' => $year,
            ],
            [
                'total_received' => $totalReceived,
                'total_paid' => $totalPaid,
                'balance' => $balanceInitial,
            ]
        );
    }
}
