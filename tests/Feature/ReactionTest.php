<?php

namespace Tests\Feature;

use App\Enum\Reaction;
use App\Models\Author;
use App\Models\Post;
use App\Models\ReactionPost;
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
            'react' => Reaction::LIKE,
        ];

        $post = Post::find($post->id);
        $likes = $post->likes;

        $response = $this->postJson(route("api.$this->route_name.likeOrDislike"), $request);
        $response->assertCreated();

        $reaction = ReactionPost::where([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ])->first();

        $post = Post::find($post->id);

        $this->assertEquals(Reaction::LIKE, $reaction->react);
        $this->assertEquals($likes + 1, $post->likes);
    }

    public function test_dislike_post()
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
            'react' => Reaction::DISLIKE,
        ];

        $post = Post::find($post->id);
        $dislikes = $post->dislikes;

        $response = $this->postJson(route("api.$this->route_name.likeOrDislike"), $request);
        $response->assertCreated();

        $reaction = ReactionPost::where([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ])->first();

        $post = Post::find($post->id);

        $this->assertEquals(Reaction::DISLIKE, $reaction->react);
        $this->assertEquals($dislikes + 1, $post->dislikes);
    }

    public function test_disliking_a_post_that_has_already_been_liked()
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
            'react' => Reaction::LIKE,
        ];

        $response = $this->postJson(route("api.$this->route_name.likeOrDislike"), $request);
        $response->assertCreated();

        $reaction = ReactionPost::where([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ])->first();

        $this->assertEquals(Reaction::LIKE, $reaction->react);

        $request = [
            'post_id' => $post->id,
            'react' => Reaction::DISLIKE,
        ];

        $response = $this->postJson(route("api.$this->route_name.likeOrDislike"), $request);
        $response->assertCreated();

        $reaction = ReactionPost::where([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ])->first();

        $this->assertEquals(Reaction::DISLIKE, $reaction->react);
    }
}
