<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class JobCategoryTest extends TestCase
{
    use WithFaker;

    protected string $route_name = 'job_category';


    public function test_authorize_for_sanctum_user()
    {
        $response = $this->getJson(route("api.$this->route_name.index"));
        $response->assertStatus(401);
    }

    public function test_get_all_job_categories()
    {
        Sanctum::actingAs(
            User::factory()->create()
        );
        $response = $this->getJson(route("api.$this->route_name.index"));
        $response->assertOk();
    }

    public function test_store_job_category()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $request = [
            'name' => $this->faker()->name,
        ];

        $response = $this->postJson(route("api.$this->route_name.store"), $request);
        $response->assertCreated();
    }
}
