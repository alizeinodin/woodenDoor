<?php

namespace App\Http\Controllers;

use App\Http\Requests\VerificationCode\SendRequest;
use App\Mail\VerificationCodeMail;
use App\Models\VerificationCode;
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

        VerificationCode::create([
            'email' => $cleanData['email'],
            'code' => $code
        ]);

        Mail::to($cleanData['email'])->send(new VerificationCodeMail($code));

        $response = [
            'message' => 'verification code sent'
        ];

        return response($response, ResponseHttp::HTTP_OK);
    }

    public function verify(VerifyRequest $request)
    {

    }
}
