<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Recurrence extends Model
{
    use HasFactory;

    protected $fillable = [
        'frequency',
        'starts_at',
        'ends_at',
        'last_generated_at',
        'income_id',
        'expense_id',
    ];

    protected $casts = [
        'starts_at' => 'date',
        'ends_at' => 'date',
        'last_generated_at' => 'date',
    ];

    // Se no futuro tiver relacionamento com incomes ou expenses, pode adicionar por exemplo:
     public function income(): BelongsTo
     {
         return $this->belongsTo(Income::class, 'income_id');
     }

     public function expenses(): BelongsTo
     {
         return $this->belongsTo(Expense::class, 'expense_id');
     }
}
