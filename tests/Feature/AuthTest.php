<?php

namespace Tests\Feature;

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
        $request = [
            'username' => 'test',
            'email' => 'email@gmail.com',
            'password' => 'password',
            'first_name' => 'name',
            'last_name' => 'last_name',
            'sex' => 'MALE'
        ];
        $response = $this->postJson(route('api.auth.register'), $request);

        $response->assertCreated();
    }
}
