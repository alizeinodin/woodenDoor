<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PostCategoryTest extends TestCase
{
    use WithFaker;

    protected string $route_name = 'post_category';


    public function test_authorize_for_sanctum_user()
    {
        $response = $this->getJson(route("api.$this->route_name.index"));
        $response->assertStatus(401);
    }

    public function test_store_post_category()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $request = [
            'title' => $this->faker()->name,
        ];

        $response = $this->postJson(route("api.$this->route_name.store"), $request);
        $response->assertCreated();
    }
}
