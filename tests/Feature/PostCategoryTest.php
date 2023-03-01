<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\Post;
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

    public function test_show_all_posts_of_category()
    {

        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $postCategory = new PostCategory();
        $postCategory->title = $this->faker->name;
        $postCategory->link = $this->faker->url;
        $postCategory->save();

        $author = new Author();
        $user->author()->save($author);

        $post = new Post();
        $post->title = $this->faker()->name;
        $post->description = $this->faker()->name;
        $post->content = $this->faker()->text;
        $post->uri = $this->faker()->url;
        $post->category_id = $postCategory->id;

        $author->posts()->save($post);

        $response = $this->getJson(route("api.$this->route_name.show_posts", ['postCategory' => $postCategory]));
        $response->assertStatus(200);
    }
}
