<?php

namespace App\Enum;

enum VerificationCodeStatus: string
{
    case not_confirmed = 'not-confirmed';
    case confirmed = 'confirmed';
}
