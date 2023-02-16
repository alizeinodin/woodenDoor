<?php

namespace App\Http\Controllers\v1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Models\VerificationCode;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseHttp;

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
            'password' => bcrypt($cleanData['password']),
            'first_name' => $cleanData['first_name'],
            'last_name' => $cleanData['last_name'],
            'sex' => $cleanData['sex'] == 'MALE' ? true : false,
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
            'token_type' => 'Barber',
        ];

        $verifiable = VerificationCode::where('email', $cleanData['email'])->latest('id')->first();
        $verifiable->delete();

        return response($response, ResponseHttp::HTTP_CREATED);
    }

    /**
     * @param LoginRequest $request
     * @return Response|Application|ResponseFactory
     * @throws ValidationException
     */
    public function login(LoginRequest $request): Response|Application|ResponseFactory
    {
        $cleanData = $request->validated();

        $user = User::where('email', $cleanData['email'])->latest('id')->first();

        if (Auth::attempt(['email' => $cleanData['email'], 'password' => $cleanData['password']])) {

            $response = [
                'user' => $user,
                'access_token' => $user->createToken('auth_token')->plainTextToken,
                'token_type' => 'Bearer',
            ];

            return response($response, ResponseHttp::HTTP_OK);
        }

        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.']
        ]);
    }

    /**
     * @param Request $request
     * @return Response|Application|ResponseFactory
     */
    public function logout(Request $request): Response|Application|ResponseFactory
    {
        $request->user()->tokens()->delete(); // logout from all devices

        $response = [
            'message' => 'You have successfully logged out!',
        ];

        return response($response, ResponseHttp::HTTP_NO_CONTENT);
    }
}
