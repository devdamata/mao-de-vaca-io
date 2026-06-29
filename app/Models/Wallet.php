<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'initial_balance',
    ];

    protected $casts = [
        'initial_balance' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Saldo atual da carteira = saldo inicial + entradas - saídas (todas as transações).
     */
    public function currentBalance(): float
    {
        $income = (float) $this->transactions()->where('type', 'income')->sum('amount');
        $expense = (float) $this->transactions()->where('type', 'expense')->sum('amount');

        return (float) $this->initial_balance + $income - $expense;
    }

    /**
     * Movimentação (recebido/pago/líquido) de um mês específico.
     *
     * @return array{received: float, paid: float, net: float}
     */
    public function monthlyMovement(int $month, int $year): array
    {
        $received = (float) $this->transactions()
            ->where('type', 'income')
            ->whereMonth('occurred_at', $month)
            ->whereYear('occurred_at', $year)
            ->sum('amount');

        $paid = (float) $this->transactions()
            ->where('type', 'expense')
            ->whereMonth('occurred_at', $month)
            ->whereYear('occurred_at', $year)
            ->sum('amount');

        return [
            'received' => $received,
            'paid' => $paid,
            'net' => $received - $paid,
        ];
    }
}
