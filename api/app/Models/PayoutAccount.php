<?php

namespace App\Models;

use App\Enums\PayoutAccountType;
use App\Enums\PixKeyType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayoutAccount extends Model {

    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'pix_key',
        'pix_key_type',
        'holder_name',
        'document',
        'is_default',
        'verified_at'
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'verified_at' => 'datetime',
        'type' => PayoutAccountType::class,
        'pix_key_type' => PixKeyType::class
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}