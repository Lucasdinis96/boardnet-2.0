<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TradeImage extends Model
{
    protected $fillable = [
        'trade_id',
        'path',
        'is_primary',
        'order'
    ];

    protected $casts = [
        'is_primary' => 'boolean'
    ];

    public function trade(): BelongsTo {
        return $this->belongsTo(Trade::class);
    }
}