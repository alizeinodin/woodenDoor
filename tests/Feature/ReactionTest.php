<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ReactionTest extends TestCase
{
    use WithFaker;

    protected string $route_name = 'reaction';

    public function test_authorize_for_sanctum_user()
    {
        $response = $this->getJson(route("api.$this->route_name.index"));
        $response->assertStatus(401);
    }

    public function test_get_all_reactions()
    {
        Sanctum::actingAs(
            User::factory()->create()
        );
        $response = $this->getJson(route("api.$this->route_name.index"));
        $response->assertOk();
    }

    public function test_like_post()
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

        $request = [
            'post_id' => $post->id,
            'react' => 'like',
        ];

        $response = $this->postJson(route("api.$this->route_name.likeOrDislike"), $request);
        $response->assertCreated();
    }
}
