<?php

namespace App\Http\Controllers;

use App\Mail\VerificationCodeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class VerificationCodeController extends Controller
{
    /**
     * @throws \Exception
     */
    public function send()
    {
        $code = random_int(100000, 999999);

        Mail::to();
    }
}
