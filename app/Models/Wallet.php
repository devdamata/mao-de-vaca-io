<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'initial_balance',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function balances(): HasMany
    {
        return $this->hasMany(Balance::class);
    }
}
