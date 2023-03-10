<?php

namespace Tests\Feature;

use App\Enum\VerificationCodeStatus;
use App\Models\User;
use App\Models\VerificationCode;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use WithFaker;

    /**
     * test sign up user
     */
    public function test_register_as_employee(): void
    {

        $email = $this->faker()->email;

        $request = [
            'email' => $email
        ];

        $response = $this->postJson(route('api.verification_code.send', $request));

        $response->assertOk();

        $code = VerificationCode::where('email', $email)->latest('id')->first()['code'];

        $request['code'] = $code;

        $response = $this->postJson(route('api.verification_code.verify', $request));

        $response->assertOk();

        $verifiable = VerificationCode::where('email', $email)->latest('id')->first();

        $this->assertEquals(VerificationCodeStatus::confirmed, $verifiable['verify']);

        $request = [
            'username' => $this->faker()->userName,
            'email' => $email,
            'password' => 'password',
            'first_name' => 'name',
            'last_name' => 'last_name',
            'sex' => 'MALE',
            'type' => 'true', // register as employee
        ];
        $response = $this->postJson(route('api.auth.register'), $request);

        $response->assertCreated();

        $user = User::where('email', $email)->latest('id')->first();

        $this->assertTrue($user->hasRole('Employee'));

    }

    public function test_register_as_employer()
    {
        $email = $this->faker()->email;

        $request = [
            'email' => $email
        ];

        $response = $this->postJson(route('api.verification_code.send', $request));

        $response->assertOk();

        $code = VerificationCode::where('email', $email)->latest('id')->first()['code'];

        $request['code'] = $code;

        $response = $this->postJson(route('api.verification_code.verify', $request));

        $response->assertOk();

        $verifiable = VerificationCode::where('email', $email)->latest('id')->first();

        $this->assertEquals(VerificationCodeStatus::confirmed, $verifiable['verify']);

        $request = [
            'username' => $this->faker()->userName,
            'email' => $email,
            'password' => 'password',
            'first_name' => 'name',
            'last_name' => 'last_name',
            'sex' => 'MALE',
            'type' => 'false', // register as employer
            'persian_name' => 'sherkat',
            'english_name' => 'company',
            'nick_name' => $this->faker()->userName,
            'address' => 'iran tehran'
        ];
        $response = $this->postJson(route('api.auth.register'), $request);
        $response->assertCreated();
    }

    public function test_login_user_as_employee()
    {
        /*
         * register a user with
         * email and verify
         */
        // --------------------------------------------

        $email = $this->faker()->email;
        $password = $this->faker()->password;

        $request = [
            'email' => $email
        ];

        $response = $this->postJson(route('api.verification_code.send', $request));

        $response->assertOk();

        $code = VerificationCode::where('email', $email)->latest('id')->first()['code'];

        $request['code'] = $code;

        $response = $this->postJson(route('api.verification_code.verify', $request));

        $response->assertOk();

        $verifiable = VerificationCode::where('email', $email)->latest('id')->first();

        $this->assertEquals(VerificationCodeStatus::confirmed, $verifiable['verify']);

        $request = [
            'username' => $this->faker()->userName,
            'email' => $email,
            'password' => $password,
            'first_name' => 'name',
            'last_name' => 'last_name',
            'sex' => 'MALE',
            'type' => 'true', // register as employee
        ];
        $response = $this->postJson(route('api.auth.register'), $request);
        $response->assertCreated();

        // --------------------------------------------

        $request = [
            'email' => $email,
            'password' => $password,
            'type' => 'true',
        ];

        $response = $this->postJson(route('api.auth.login', $request));

        $response->assertOk();

        $this->assertAuthenticated();
    }

    public function test_login_user_without_permission_to_role()
    {

        /*
         * register a user with
         * email and verify
         */
        // --------------------------------------------

        $email = $this->faker()->email;
        $password = $this->faker()->password;

        $request = [
            'email' => $email
        ];

        $response = $this->postJson(route('api.verification_code.send', $request));

        $response->assertOk();

        $code = VerificationCode::where('email', $email)->latest('id')->first()['code'];

        $request['code'] = $code;

        $response = $this->postJson(route('api.verification_code.verify', $request));

        $response->assertOk();

        $verifiable = VerificationCode::where('email', $email)->latest('id')->first();

        $this->assertEquals(VerificationCodeStatus::confirmed, $verifiable['verify']);

        $request = [
            'username' => $this->faker()->userName,
            'email' => $email,
            'password' => $password,
            'first_name' => 'name',
            'last_name' => 'last_name',
            'sex' => 'MALE',
            'type' => 'true', // register as employee
        ];
        $response = $this->postJson(route('api.auth.register'), $request);
        $response->assertCreated();

        // --------------------------------------------

        $request = [
            'email' => $email,
            'password' => $password,
            'type' => 'false',
        ];

        $response = $this->postJson(route('api.auth.login', $request));

        $response->assertStatus(403);
    }


    /**
     * @throws \Throwable
     */
    public function test_login_user_as_employer()
    {
        /*
         * register a user with
         * email and verify
         */
        // --------------------------------------------

        $email = $this->faker()->email;
        $password = $this->faker()->password;

        $request = [
            'email' => $email
        ];

        $response = $this->postJson(route('api.verification_code.send', $request));

        $response->assertOk();

        $code = VerificationCode::where('email', $email)->latest('id')->first()['code'];

        $request['code'] = $code;

        $response = $this->postJson(route('api.verification_code.verify', $request));

        $response->assertOk();

        $verifiable = VerificationCode::where('email', $email)->latest('id')->first();

        $this->assertEquals(VerificationCodeStatus::confirmed, $verifiable['verify']);

        $request = [
            'username' => $this->faker()->userName,
            'email' => $email,
            'password' => $password,
            'first_name' => 'name',
            'last_name' => 'last_name',
            'sex' => 'MALE',
            'type' => 'false', // register as employer
            'persian_name' => 'sherkat',
            'english_name' => 'company',
            'nick_name' => $this->faker()->userName,
            'address' => 'iran tehran'
        ];
        $response = $this->postJson(route('api.auth.register'), $request);
        $response->assertCreated();

        // --------------------------------------------

        $request = [
            'email' => $email,
            'password' => $password,
            'type' => 'false',
        ];

        $response = $this->postJson(route('api.auth.login', $request));

        $response->assertOk();

        $this->assertAuthenticated();
        $this->assertEquals('Employer', $response->decodeResponseJson()['role']);
    }


    /**
     * @throws \Throwable
     */
    public function test_logout_user()
    {
        Sanctum::actingAs(
            User::factory()->create()
        );
        $this->assertAuthenticated();

        $response = $this->getJson(route('api.auth.logout'));
        $response->assertStatus(204);

    }

    public function test_register_as_employee_for_user_which_register_as_employer()
    {
        $email = $this->faker()->email;

        $request = [
            'email' => $email
        ];

        $response = $this->postJson(route('api.verification_code.send', $request));

        $response->assertOk();

        $code = VerificationCode::where('email', $email)->latest('id')->first()['code'];

        $request['code'] = $code;

        $response = $this->postJson(route('api.verification_code.verify', $request));

        $response->assertOk();

        $verifiable = VerificationCode::where('email', $email)->latest('id')->first();

        $this->assertEquals(VerificationCodeStatus::confirmed, $verifiable['verify']);

        $request = [
            'username' => $this->faker()->userName,
            'email' => $email,
            'password' => 'password',
            'first_name' => 'name',
            'last_name' => 'last_name',
            'sex' => 'MALE',
            'type' => 'false', // register as employer
            'persian_name' => 'sherkat',
            'english_name' => 'company',
            'nick_name' => $this->faker()->userName,
            'address' => 'iran tehran'
        ];
        $response = $this->postJson(route('api.auth.register'), $request);
        $response->assertCreated();

        $request = [
            'email' => $email
        ];

        $response = $this->postJson(route('api.verification_code.send', $request));

        $response->assertOk();

        $code = VerificationCode::where('email', $email)->latest('id')->first()['code'];

        $request['code'] = $code;

        $response = $this->postJson(route('api.verification_code.verify', $request));

        $response->assertOk();

        $verifiable = VerificationCode::where('email', $email)->latest('id')->first();

        $this->assertEquals(VerificationCodeStatus::confirmed, $verifiable['verify']);

        $request = [
            'username' => $this->faker()->userName,
            'email' => $email,
            'password' => 'password',
            'first_name' => 'name',
            'last_name' => 'last_name',
            'sex' => 'MALE',
            'type' => 'true', // register as employee
        ];
        $response = $this->postJson(route('api.auth.register', $request));

        $response->assertCreated();

        $user = User::where('email', $email)->latest('id')->first();

        $this->assertTrue($user->hasRole('Employee'));
    }
}
