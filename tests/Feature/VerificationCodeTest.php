<?php

namespace Tests\Feature;

use App\Enum\VerificationCodeStatus;
use App\Models\VerificationCode;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VerificationCodeTest extends TestCase
{
    use LazilyRefreshDatabase;
    /**
     * Test send verification
     * code to email of user
     */
    public function test_send_verification_code(): void
    {
        $request = [
            'email' => 'alizeinodin79@gmail.com'
        ];

        $response = $this->postJson(route('api.verification_code.send', $request));

        $response->assertOk();
    }

    /**
     * Test verify email
     * by check code
     */
    public function test_verify_email_by_verification_code()
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
    }
}
