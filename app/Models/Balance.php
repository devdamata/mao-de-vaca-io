<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Balance extends Model
{
    /**
     * Os atributos que podem ser atribuídos em massa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'wallet_id',
        'total_received',
        'total_paid',
        'balance',
        'month',
        'year',
    ];

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }

    public function getMonthYearAttribute(): string
    {
        return str_pad($this->month, 2, '0', STR_PAD_LEFT) . '/' . $this->year;
    }
}
