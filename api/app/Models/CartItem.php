<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model {

    use HasFactory;
    protected $table = 'cart_items';
    protected $fillable = [
        'cart_id',
        'trade_item_id'
    ];

    public function cart() {
        return $this->belongsTo(Cart::class);
    }

    public function tradeItem() {
        return $this->belongsTo(TradeItem::class);
    }
}