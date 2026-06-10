<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Trade extends Model {
    use HasFactory;
    
    protected $table = 'trades';
    protected $fillable = [
        'title',
        'description',
        'user_id'
    ];

    public function user () {
        return $this->belongsTo(User::class);
    }

   public function boardgames () {
        return $this->belongsToMany(Boardgame::class, 'trade_items', 'trade_id', 'boardgame_id')
                    ->using(TradeItem::class)
                    ->withPivot(['id','value','status'])
                    ->withTimestamps();
    }

    public function tradeItem () {
        return $this->hasMany(TradeItem::class);
    }

    public function images() {
        return $this->hasMany(TradeImage::class)->orderBy('order');
    }

    public function primaryImage(): HasOne {
        return $this->hasOne(TradeImage::class)->where('is_primary', true);
    }
}
