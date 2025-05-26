<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
