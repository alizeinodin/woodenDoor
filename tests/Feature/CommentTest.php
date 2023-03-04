<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use WithFaker;

    protected string $route_name = 'comment';


    public function test_authorize_for_sanctum_user()
    {
        $response = $this->getJson(route("api.$this->route_name.index"));
        $response->assertStatus(401);
    }

    public function test_get_all_comments()
    {
        Sanctum::actingAs(
            User::factory()->create()
        );
        $response = $this->getJson(route("api.$this->route_name.index"));
        $response->assertOk();
    }

    public function test_store_comment()
    {
        $user = User::factory()->create();

        $author = new Author();
        $user->author()->save($author);

        Sanctum::actingAs($user);

        $post = new Post();

        $post->title = $this->faker()->name;
        $post->description = $this->faker()->name;
        $post->content = $this->faker()->text;
        $post->uri = $this->faker()->url;

        $author->posts()->save($post);

        $request = [
            'title' => $this->faker()->name,
            'description' => $this->faker()->name,
            'content' => $this->faker()->text,
            'post_id' => $post->id,
        ];

        $response = $this->postJson(route("api.$this->route_name.store", ['post' => $post]), $request);
        $response->assertCreated();
    }
}
