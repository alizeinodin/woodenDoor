<?php

namespace App\Http\Middleware\Auth;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseHttp;

class HasRoleForLogin
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return Response
     * @throws ValidationException
     */
    public function handle(Request $request, Closure $next)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
            'type' => 'required|bool',
        ]);

        if ($validator->fails()) {
            throw ValidationException::withMessages((array)$validator->errors());
        }
        $email = $request->input('email');
        $type = $request->input('type');

        $user = User::where('email', $email)->latest('id')->first();

        $result = $type ? is_null($user->employee) : is_null($user->employer);

        if ($result) {

            $response = [
                'message' => 'You are not registered'
            ];

            return response($response, ResponseHttp::HTTP_UNAUTHORIZED);
        }


        return $next($request);
    }
}
