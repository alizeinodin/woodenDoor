<?php

namespace App\Http\Middleware\Auth;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseHttp;

class UserAlreadyRegistered
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return Application|ResponseFactory|Response|Closure
     */
    public function handle(Request $request, Closure $next)
    {
        $user = User::where('email', $request['email'])->first();

        if (!is_null($user)) {

            $type = $request->input('type') == 'true' ? true : false;

            if ($type and is_null($user->employee)) {
                return $next($request);
            } else if (!$type and is_null($user->employer)) {
                return $next($request);
            }

            $response = [
                'message' => 'User already registered with this email',
            ];

            return response($response, ResponseHttp::HTTP_FORBIDDEN);
        }
        return $next($request);
    }
}
