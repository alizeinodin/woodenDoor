<?php

namespace App\Http\Controllers;

use App\Http\Requests\VerifiactionCode\SendRequest;
use App\Mail\VerificationCodeMail;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response as ResponseHttp;

class VerificationCodeController extends Controller
{
    /**
     * send verification code to email of user
     *
     * @throws \Exception
     */
    public function send(SendRequest $request): Response|Application|ResponseFactory
    {
        $cleanData = $request->validated();

        $code = random_int(100000, 999999);

        Mail::to($cleanData['email'])->send(new VerificationCodeMail($code));

        $response = [
            'message' => 'verification code sent'
        ];

        return response($response, ResponseHttp::HTTP_OK);
    }
}