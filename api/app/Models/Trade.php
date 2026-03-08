<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        return $this->belongsToMany(Boardgame::class, 'tradeItens', 'trade_id', 'boardgame_id')
                    ->withPivot('value')
                    ->withTimestamps();
    }
}
