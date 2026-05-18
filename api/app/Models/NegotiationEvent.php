<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Enums\NegotiationEventType;

class NegotiationEvent extends Model {

    use HasFactory;

    protected $fillable = [

        'negotiation_id',

        'event',

        'user_id',

        'metadata'
    ];

    protected $casts = [

        'event' => NegotiationEventType::class,

        'metadata' => 'array'
    ];

    public function negotiation() {

        return $this->belongsTo(
            Negotiation::class
        );
    }

    public function user() {

        return $this->belongsTo(User::class);
    }
}