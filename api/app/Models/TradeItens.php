<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TradeItens extends Model {

    use HasFactory;
    
    protected $table = 'tradeItens';
    protected $fillable = [
        'trade_id',
        'boardgame_id',
        'value'
    ];

    public function trade() {
        return $this->belongsTo(Trade::class);
    }

    public function boardgame() {
        return $this->belongsTo(Boardgame::class);
    }
}
