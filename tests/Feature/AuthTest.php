<?php

namespace Tests\Feature;

use App\Enum\VerificationCodeStatus;
use App\Models\VerificationCode;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

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
}
