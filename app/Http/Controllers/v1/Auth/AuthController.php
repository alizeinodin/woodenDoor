<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response AS ResponseHttp;

class AuthController extends Controller
{
    /**
     * @param RegisterRequest $request
     * @return Response|Application|ResponseFactory
     */
    public function register(RegisterRequest $request): Response|Application|ResponseFactory
    {
        $cleanData = $request->validated();

        $user = User::create([
            'username' => $cleanData['username'],
            'email' => $cleanData['email'],
            'first_name' => $cleanData['first_name'],
            'last_name' => $cleanData['last_name'],
            'sex' => $cleanData['sex'],
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
            'token_type' => 'Barber',
        ];

        return response($response, ResponseHttp::HTTP_CREATED);
    }
}
