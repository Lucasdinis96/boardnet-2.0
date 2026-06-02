<?php

namespace App\Models;

use App\Enums\NegotiationStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Negotiation extends Model {

    use HasFactory;
    protected $table = 'negotiations';
    protected $fillable = [
        'buyer_id',
        'seller_id',
        'status',
        'subtotal',
        'shipping_cost',
        'total',
        'shipping_address_snapshot',
        'paid_at',
        'shipped_at',
        'delivered_at',
        'completed_at',
        'canceled_at',
        'tracking_code'
    ];

    protected $casts = [
        'shipping_address_snapshot' => 'array',
        'paid_at' => 'datetime',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
        'completed_at' => 'datetime',
        'canceled_at' => 'datetime',
        'status' => NegotiationStatus::class
    ];

    public function buyer() {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function seller() {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function items() {
        return $this->hasMany(NegotiationItem::class);
    }

    public function payments() {
        return $this->hasMany(Payment::class);
    }

    public function events() {
        return $this->hasMany(NegotiationEvent::class)->latest();
    }
}