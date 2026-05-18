<?php

namespace App\Models;

use App\Enums\NegotiationItemStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NegotiationItem extends Model {

    use HasFactory;

    protected $fillable = [
        'negotiation_id',
        'trade_item_id',
        'boardgame_id',
        'price',
        'boardgame_snapshot',
        'status'
    ];

    protected $casts = [
        'boardgame_snapshot' => 'array',
        'status' => NegotiationItemStatus::class
    ];

    public function negotiation() {
        return $this->belongsTo(Negotiation::class);
    }

    public function tradeItem() {
        return $this->belongsTo(TradeItem::class);
    }

    public function boardgame() {
        return $this->belongsTo(Boardgame::class);
    }
}