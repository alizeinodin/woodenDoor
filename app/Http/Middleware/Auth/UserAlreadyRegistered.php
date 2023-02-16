<?php

namespace App\Http\Middleware\Auth;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response AS ResponseHttp;

class UserAlreadyRegistered
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return Application|ResponseFactory|Response
     */
    public function handle(Request $request, Closure $next): Application|ResponseFactory|Response
    {
        $user = User::where('email', $request['email'])->first();

        if (! is_null($user)){
            $response = [
                'message' => 'User already registered with this email',
            ];

            return response($response, ResponseHttp::HTTP_FORBIDDEN);
        }
        return $next($request);
    }
}
