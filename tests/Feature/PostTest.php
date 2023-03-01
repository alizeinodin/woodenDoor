<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PostTest extends TestCase
{
    use WithFaker;

    protected string $route_name = 'post';


    public function test_authorize_for_sanctum_user()
    {
        $response = $this->getJson(route("api.$this->route_name.index"));
        $response->assertStatus(401);
    }

    public function test_get_all_posts()
    {
        Sanctum::actingAs(
            User::factory()->create()
        );
        $response = $this->getJson(route("api.$this->route_name.index"));
        $response->assertOk();
    }

    public function test_store_post()
    {
        $user = User::factory()->create();

        $author = new Author();
        $user->author()->save($author);

        Sanctum::actingAs($user);

        $request = [
            'title' => $this->faker()->name,
            'description' => $this->faker()->name,
            'content' => $this->faker()->text,
        ];

        $response = $this->postJson(route("api.$this->route_name.store"), $request);
        $response->assertCreated();
    }


    public function test_show_post()
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

        $response = $this->getJson(route("api.$this->route_name.show", ['post' => $post->id]));
        $response->assertOk();

    }

    public function test_update_post()
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

        $title = $this->faker()->title;

        $request = [
            'title' => $title,
        ];

        $response = $this->patchJson(route("api.$this->route_name.update", ['post' => $post]), $request);
        $response->assertOk();

        $post = Post::find($post->id);
        $this->assertEquals($title, $post->title);
    }

    public function test_delete_post()
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

        $response = $this->deleteJson(route("api.$this->route_name.destroy", ['post' => $post]));
        $response->assertStatus(204);
    }

}
