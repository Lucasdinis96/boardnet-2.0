<?php

namespace App\Enums;

enum PixKeyType: string {

    case CPF = 'cpf';
    case CNPJ = 'cnpj';
    case Email = 'email';
    case Phone = 'phone';
    case Random = 'random';
}