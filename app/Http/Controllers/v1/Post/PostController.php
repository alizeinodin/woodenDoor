<?php

namespace App\Http\Controllers\v1\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StoreRequest;
use App\Models\Post;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response as ResponseHttp;

class PostController extends Controller
{
    /**
     * Display a listing of the
     * post 15 pagination
     */
    public function index()
    {
        return Post::paginate(15);
    }

    public function store(StoreRequest $request): Response|Application|ResponseFactory
    {
        $cleanData = $request->validated();

        $comment_status = $request['comment_status'] == 'ture' ? true : false;

        $post = new Post();

        $post->category_id = $cleanData['category_id'] ?? 1;
        $post->title = $cleanData['title'];
        $post->description = $cleanData['description'] ?? null;
        $post->content = $cleanData['content'] ?? null;
        $post->post_status = $cleanData['post_status'] ?? 3;
        $post->comment_status = $cleanData['comment_status'] == null ? true : $comment_status;
        $post->score = $cleanData['score'] ?? 0;
        $post->uri = $cleanData['uri'] ?? Str::slug($request['title']);
        // store path of index image

        $request->user()->posts()->save($post); // save post for user

        $response = [
            'message' => 'Post added',
            'object' => $post,
        ];

        return response($response, ResponseHttp::HTTP_CREATED);
    }

    public function show(Post $post): Application|ResponseFactory|Response
    {
        return response($post, ResponseHttp::HTTP_OK);
    }
}
