<?php

namespace App\Http\Controllers\v1\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StoreRequest;
use App\Http\Requests\Post\UpdateRequest;
use App\Models\Post;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
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

        if ($request->has('comment_status')) {
            $request['comment_status'] = $request['comment_status'] == 'true' ? true : false;
        }
        $post = new Post();

        $post->category_id = $cleanData['category_id'] ?? 1;
        $post->title = $cleanData['title'];
        $post->description = $cleanData['description'] ?? null;
        $post->content = $cleanData['content'] ?? null;
        $post->post_status = $cleanData['post_status'] ?? 3;
        $post->comment_status = $cleanData['comment_status'] ?? true;
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

    /**
     * Update the specified post in storage.
     *
     * @throws ValidationException
     */
    public function update(UpdateRequest $request, Post $post): Response|Application|ResponseFactory
    {
        $validator = Validator::make($request->all(), $request->rules());

        if ($request->has('comment_status')) {
            $request['comment_status'] = $request['comment_status'] == 'true' ? true : false;
        }

        if ($validator->fails()) {
            throw ValidationException::withMessages((array)$validator->errors());
        }

        $post->update($request->all());

        $response = [
            'message' => 'Your post updated'
        ];

        return response($response, ResponseHttp::HTTP_OK);
    }

    /**
     * Remove the specified company from storage.
     */
    public function destroy(Post $post): Response|Application|ResponseFactory
    {
        if ($post->deleteOrFail() === false) {
            $response = [
                'message' => "Couldn't delete the post"
            ];

            return response($response, ResponseHttp::HTTP_BAD_REQUEST);
        }

        $response = [
            'message' => 'The post deleted'
        ];

        return response($response, ResponseHttp::HTTP_NO_CONTENT);
    }
}
