<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StorePostTest extends TestCase
{
    use WithFaker;

    protected string $route_name = 'store_post';

    public function test_authorize_for_sanctum_user()
    {
        $response = $this->postJson(route("api.$this->route_name.store", ['post' => 1]));
        $response->assertStatus(401);
    }

}
