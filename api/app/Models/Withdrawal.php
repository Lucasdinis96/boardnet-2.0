<?php

namespace App\Models;

use App\Enums\WithdrawalStatus;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    protected $fillable = [
        'negotiation_id',
        'user_id',
        'amount',
        'status',
        'requested_at',
        'paid_at'
    ];

    protected $casts = [
        'status' => WithdrawalStatus::class,
        'requested_at' => 'datetime',
        'paid_at' => 'datetime'
    ];

    public function negotiation()
    {
        return $this->belongsTo(Negotiation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
