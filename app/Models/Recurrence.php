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

    public function getDescricaoTipoAttribute()
    {
        if ($this->income_id && $this->income) {
            return 'Receita: ' . ucfirst($this->income->description);
        }

        if ($this->expense_id && $this->expenses) {
            return 'Despesa: ' . ucfirst($this->expenses->description);
        }

        return '-';
    }

    public function getTranslateEnumFrequency()
    {
        return match ($this->status) {
            'once'      => 'Uma vez',
            'daily'     => 'Diariamente',
            'weekly'    => 'Semanalmente',
            'monthly'   => 'Mensalmente',
            'yearly'    => 'Anualmente'
        };
    }

    public function parcel(): HasMany
    {
        return $this->hasMany(Parcel::class, 'recurrence_id');
    }

    public function income(): BelongsTo
    {
        return $this->belongsTo(Income::class, 'income_id');
    }

    public function expenses(): BelongsTo
    {
        return $this->belongsTo(Expense::class, 'id');
    }
}
