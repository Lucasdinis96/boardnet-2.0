<?php

namespace App\Models;

use App\Enums\PaymentMethod;
use App\Enums\PaymentProvider;
use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model {

    use HasFactory;
    protected $table = 'payments';
    protected $fillable = [
        'negotiation_id',
        'provider',
        'payment_method',
        'status',
        'amount',
        'paid_amount',
        'installments',
        'currency',
        'provider_payment_id',
        'transaction_id',
        'payment_url',
        'provider_response',
        'expires_at',
        'paid_at'
    ];

    protected $casts = [
        'provider_response' => 'array',
        'expires_at' => 'datetime',
        'paid_at' => 'datetime',
        'status' => PaymentStatus::class,
        'payment_method' => PaymentMethod::class,
        'provider' => PaymentProvider::class,
    ];

    public function negotiation() {
        return $this->belongsTo(Negotiation::class);
    }

    public function events() {

        return $this->hasMany(
            NegotiationEvent::class
        )->latest();
    }
}