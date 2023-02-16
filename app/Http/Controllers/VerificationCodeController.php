<?php

namespace App\Http\Controllers;

use App\Enum\VerificationCodeStatus;
use App\Http\Requests\VerificationCode\SendRequest;
use App\Http\Requests\VerificationCode\VerifyRequest;
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
     * send verification code
     * to email of user
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

    /**
     * verification by check code
     * between email and user
     *
     * @param VerifyRequest $request
     * @return Response|Application|ResponseFactory
     */
    public function verify(VerifyRequest $request): Response|Application|ResponseFactory
    {
        $cleanData = $request->validated();

        $verifiable = VerificationCode::where('email', $cleanData['email'])->notExpired()->latest('id')->first();

        if (is_null($verifiable)) {
            $response = [
                'message' => 'No code has been sent to you or the code expired'
            ];

            return response($response, ResponseHttp::HTTP_NOT_FOUND);
        }

        if ($verifiable['code'] === $cleanData['code']) {
            $verifiable->update([
                'verify' => VerificationCodeStatus::confirmed
            ]);

            $response = [
                'message' => 'Your email confirmed'
            ];

            return response($response, ResponseHttp::HTTP_OK);
        } else {
            $response = [
                'message' => 'The entered code is incorrect'
            ];

            return response($response, ResponseHttp::HTTP_FORBIDDEN);
        }

    }
}
