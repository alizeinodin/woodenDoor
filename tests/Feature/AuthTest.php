<?php

namespace Tests\Feature;

use App\Enum\VerificationCodeStatus;
use App\Models\User;
use App\Models\VerificationCode;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use function Faker\Provider\pt_BR\check_digit;

class AuthTest extends TestCase
{
    use LazilyRefreshDatabase;

    /**
     * test sign up user
     */
    public function test_user_register(): void
    {

        $email = 'alizeinodin79@gmail.com';

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
            'username' => 'test',
            'email' => $email,
            'password' => 'password',
            'first_name' => 'name',
            'last_name' => 'last_name',
            'sex' => 'MALE'
        ];
        $response = $this->postJson(route('api.auth.register'), $request);

        $response->assertCreated();
    }

    public function test_login_user()
    {
        /*
         * register a user with
         * email and verify
         */
        // --------------------------------------------
        $email = 'alizeinodin79@gmail.com';
        $password = 'password';

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
            'username' => 'test',
            'email' => $email,
            'password' => $password,
            'first_name' => 'name',
            'last_name' => 'last_name',
            'sex' => 'MALE'
        ];
        $response = $this->postJson(route('api.auth.register'), $request);

        $response->assertCreated();

        // --------------------------------------------

        $request = [
            'email' => $email,
            'password' => $password,
        ];

        $response = $this->postJson(route('api.auth.login', $request));

        $response->assertOk();

        $this->assertAuthenticated();
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
}
