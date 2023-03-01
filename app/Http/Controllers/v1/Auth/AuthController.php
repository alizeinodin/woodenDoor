<?php

namespace App\Http\Controllers\v1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\v1\CompanyController;
use App\Http\Controllers\v1\UploadController;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\Author;
use App\Models\Employee;
use App\Models\Employer;
use App\Models\User;
use App\Models\VerificationCode;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseHttp;

class AuthController extends Controller
{
    private const EMPLOYEE_ROLE = 'Employee';
    private const EMPLOYER_ROLE = 'Employer';

    /**
     * @param RegisterRequest $request
     * @return Response|Application|ResponseFactory
     * @throws ValidationException
     */
    public function register(RegisterRequest $request): Response|Application|ResponseFactory
    {
        $cleanData = $request->validated();
        $user = User::where('email', $cleanData['email'])->latest('id')->first();

        if (is_null($user)) {

            $validator = Validator::make($cleanData, [
                'username' => 'unique:users',
                'email' => 'unique:users',
            ]);

            if ($validator->fails()) {
                throw ValidationException::withMessages((array)$validator->errors());
            }

            $user = User::create([
                'username' => $cleanData['username'],
                'email' => $cleanData['email'],
                'password' => bcrypt($cleanData['password']),
                'first_name' => $cleanData['first_name'],
                'last_name' => $cleanData['last_name'],
                'sex' => $cleanData['sex'] == 'MALE' ? true : false,
            ]);
        }


        $type = $cleanData['type'] == 'true' ? true : false;

        $cleanData['file'] = $request->input('file') !== null ?
            (new UploadController())->storeImage($cleanData['file']) : null;

        $type ?
            $this->register_as_employee($cleanData, $user) :
            $this->register_as_employer($cleanData, $user);

        // create author for user
        $author = new Author();
        $author->user()->associate($user);

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

        $type = $cleanData['type'] == 'true' ? true : false;


        if (Auth::attempt(['email' => $cleanData['email'], 'password' => $cleanData['password']])) {

            $role = $type ? self::EMPLOYEE_ROLE : self::EMPLOYER_ROLE;
            $user->syncRoles([$role]);

            $response = [
                'user' => $user,
                'access_token' => $user->createToken('auth_token')->plainTextToken,
                'token_type' => 'Bearer',
                'role' => $role,
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
     * @return void
     */
    private function register_as_employee(array $cleanData, User $user): void
    {
        $employee = new Employee();

        $employee->province = $cleanData['province'] ?? null;
        $employee->address = $cleanData['address'] ?? null;
        $employee->about_me = $cleanData['about_me'] ?? null;
        $employee->min_salary = $cleanData['min_salary'] ?? null;
        $employee->military_status = $cleanData['military_status'] ?? null;
        $employee->job_position_title = $cleanData['job_position_title'] ?? null;
        $employee->job_position_status = $cleanData['job_position_status'] ?? null;

        $user->employee()->save($employee);

        $user->syncRoles([self::EMPLOYEE_ROLE]);
    }

    private function register_as_employer(array $cleanData, User $user)
    {
        $employer = new Employer();

        $user->employer()->save($employer);

        $company = (new CompanyController())->add_company($cleanData, $user);

        $user->syncRoles([self::EMPLOYER_ROLE]);
    }
}
