<?php

namespace App\Services;

use App\Mail\VerifyEmail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MailService {

    public function verifyEmail(array $data){
        $token = Crypt::encrypt([
            'email' => $data['email'],
            'id' => $data['id']
        ]);
        Mail::to($data['email'], $data['name'])->send(new VerifyEmail($data, $token));
    }
}