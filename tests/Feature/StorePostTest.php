<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
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

    public function test_store_post()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $author = new Author();
        $user->author()->save($author);

        $post = new Post();

        $post->title = $this->faker()->name;
        $post->description = $this->faker()->name;
        $post->content = $this->faker()->text;
        $post->uri = $this->faker()->url;

        $author->posts()->save($post);

        $response = $this->postJson(route("api.$this->route_name.store", ['post' => $post->id]));
        $response->assertOk();
    }

    public function test_un_store_post()
    {

        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $author = new Author();
        $user->author()->save($author);

        $post = new Post();

        $post->title = $this->faker()->name;
        $post->description = $this->faker()->name;
        $post->content = $this->faker()->text;
        $post->uri = $this->faker()->url;

        $author->posts()->save($post);

        $response = $this->postJson(route("api.$this->route_name.store", ['post' => $post->id]));
        $response->assertOk();

        $response = $this->postJson(route("api.$this->route_name.unStore", ['post' => $post->id]));
        $response->assertOk();
    }

}
