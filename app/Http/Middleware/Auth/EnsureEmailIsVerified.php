<?php

namespace App\Http\Middleware\Auth;

use App\Http\Requests\VerificationCode\SendRequest;
use App\Models\VerificationCode;
use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseHttp;

class EnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return Application|ResponseFactory|Response
     */
    public function handle(Request $request, Closure $next)
    {
        $verifiable = VerificationCode::where('email', $request['email'])->notExpired()->latest('id')->first();

        if (is_null($verifiable)) {
            $response = [
                'message' => 'First, verify your email',
            ];

            return response($response, ResponseHttp::HTTP_FORBIDDEN);
        }
        return $next($request);
    }
}
