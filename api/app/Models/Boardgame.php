<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Boardgame extends Model {
    use HasFactory;
    
    protected $table = 'boardgames';
    protected $fillable = [
        'title',
        'publisher',
        'players',
        'playtime',
        'age_range',
        'description',
        'cover'
    ];

    public function trades() {
        return $this->belongsToMany(Trade::class, 'tradeItens', 'boardgame_id', 'trade_id')
                    ->withPivot('value')
                    ->withTimestamps();
    }

    public function users() {
        return $this->belongsToMany(User::class, 'collections');
    }
}
