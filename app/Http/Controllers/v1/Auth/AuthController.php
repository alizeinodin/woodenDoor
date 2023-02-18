<?php

namespace App\Http\Controllers\v1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\Employee;
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
    private const EMPLOYEE_ROLE = 'employee';
    private const EMPLOYER_ROLE = 'employer';

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

    /**
     *
     * @param array $cleanData
     * @param User $user
     * @return User
     */
    private function register_as_employee(array $cleanData, User $user): User
    {
        $employee = Employee::create([
            'province' => $cleanData['province'],
            'address' => $cleanData['address'],
            'about_me' => $cleanData['about_me'],
            'min_salary' => $cleanData['min_salary'],
            'military_status' => $cleanData['military_status'],
            'job_position_title' => $cleanData['job_position_title'],
            'job_position_status' => $cleanData['job_position_status'],
        ]);

        $user->employee()->associate($employee);
        $user->save();

        return $user->assignRole(self::EMPLOYEE_ROLE);
    }
}
