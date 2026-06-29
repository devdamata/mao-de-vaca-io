<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Parcel extends Model
{
    protected $fillable = [
        'recurrence_id',
        'due_date',
        'amount',
        'is_income',
        'is_paid',
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'amount' => 'decimal:2',
        'is_income' => 'boolean',
        'is_paid' => 'boolean',
    ];

    public function recurrence(): BelongsTo
    {
        return $this->belongsTo(Recurrence::class, 'recurrence_id');
    }

    public function transaction(): HasOne
    {
        return $this->hasOne(Transaction::class);
    }

    protected static function booted(): void
    {
        static::saved(function (Parcel $parcel) {
            if ($parcel->wasRecentlyCreated || $parcel->wasChanged('is_paid')) {
                $parcel->syncTransaction();
            }
        });

        static::deleted(function (Parcel $parcel) {
            $parcel->transaction()->delete();
        });
    }

    /**
     * Cria/atualiza a transação no ledger quando a parcela está paga,
     * ou remove-a quando deixa de estar paga.
     */
    public function syncTransaction(): void
    {
        $this->loadMissing('recurrence.expenses', 'recurrence.income');

        $walletId = $this->recurrence?->expenses?->wallet_id
            ?? $this->recurrence?->income?->wallet_id;

        if (! $walletId) {
            return;
        }

        if (! $this->is_paid) {
            Transaction::where('parcel_id', $this->id)->delete();

            return;
        }

        Transaction::updateOrCreate(
            ['parcel_id' => $this->id],
            [
                'wallet_id' => $walletId,
                'type' => $this->is_income ? 'income' : 'expense',
                'amount' => $this->amount,
                'description' => $this->recurrence?->income?->description
                    ?? $this->recurrence?->expenses?->description,
                'occurred_at' => $this->due_date,
            ]
        );
    }
}
