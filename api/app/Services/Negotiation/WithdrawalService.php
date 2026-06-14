<?php

namespace App\Services\Negotiation;

use App\Enums\WithdrawalStatus;
use App\Models\Negotiation;
use App\Models\Withdrawal;
use Illuminate\Support\Facades\Log;

class WithdrawalService
{
    public function createFromNegotiation(Negotiation $negotiation): Withdrawal
    {
        return Withdrawal::firstOrCreate(
            [
                'negotiation_id' => $negotiation->id,
                'user_id' => $negotiation->seller_id,
                'amount' => $negotiation->total,
                'status' => WithdrawalStatus::AVAILABLE
            ]
        );
    }
}