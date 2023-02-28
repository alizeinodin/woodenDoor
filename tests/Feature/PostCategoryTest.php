<?php

namespace Tests\Feature;

use App\Models\PostCategory;
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

    public function test_update_post_category()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $postCategory = new PostCategory();
        $postCategory->title = $this->faker->name;
        $postCategory->link = $this->faker->url;
        $postCategory->save();

        $request = [
            'title' => 'title2',
        ];

        $response = $this->patchJson(route("api.$this->route_name.update", ['post_category' => $postCategory]), $request);
        $response->assertOk();

        $postCategory = PostCategory::find($postCategory->id);
        $this->assertEquals('title2', $postCategory->title);
    }

    public function test_delete_post_category()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $postCategory = new PostCategory();
        $postCategory->title = $this->faker->name;
        $postCategory->link = $this->faker->url;
        $postCategory->save();

        $response = $this->deleteJson(route("api.$this->route_name.destroy", ['post_category' => $postCategory]));
        $response->assertStatus(204);
    }
}
