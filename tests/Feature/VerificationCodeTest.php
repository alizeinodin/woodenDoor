<?php

namespace Tests\Feature;

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
}
