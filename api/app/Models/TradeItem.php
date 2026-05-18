<?php

namespace App\Models;

use App\Enums\TradeItemStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TradeItem extends Model {

    use HasFactory;

    protected $fillable = [
        'trade_id',
        'boardgame_id',
        'value',
        'status',
        'reserved_until'
    ];

    protected $casts = [
        'status' => TradeItemStatus::class,
        'reserved_until' => 'datetime'
    ];

    public function trade() {
        return $this->belongsTo(Trade::class);
    }

    public function boardgame() {
        return $this->belongsTo(Boardgame::class);
    }

    public function negotiationItems() {
        return $this->hasMany(NegotiationItem::class);
    }
}