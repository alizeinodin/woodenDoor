<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\Comment;
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
            'content' => $this->faker()->text,
            'post_id' => $post->id,
        ];

        $response = $this->postJson(route("api.$this->route_name.store", ['post' => $post]), $request);
        $response->assertCreated();
    }


    public function test_show_comment()
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

        $comment = new Comment();

        $comment->content = $this->faker->text;
        $comment->post_id = $post->id;
        $comment->user_id = $user->id;

        $comment->save();

        $response = $this->getJson(route("api.$this->route_name.show", ['comment' => $comment->id]));
        $response->assertOk();
    }

    public function test_update_comment()
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

        $comment = new Comment();

        $comment->content = $this->faker->text;
        $comment->post_id = $post->id;

        $user->comments()->save($comment);

        $content = $this->faker()->text;

        $request = [
            'content' => $content,
            'status' => 2,
        ];

        $response = $this->patchJson(route("api.$this->route_name.update", ['comment' => $comment]), $request);
        $response->assertOk();

        $comment = Comment::find($comment->id);
        $this->assertEquals($content, $comment->content);
    }

    public function test_delete_comment()
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

        $comment = new Comment();

        $comment->content = $this->faker->text;
        $comment->post_id = $post->id;

        $user->comments()->save($comment);

        $response = $this->deleteJson(route("api.$this->route_name.destroy", ['comment' => $comment]));
        $response->assertStatus(204);
    }
}
