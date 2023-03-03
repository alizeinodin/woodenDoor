<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\StoreRequest;
use App\Http\Requests\Comment\UpdateRequest;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseHttp;

class CommentController extends Controller
{
    public function index(): Collection
    {
        return Comment::all();
    }

    public function get_comments(Post $post): LengthAwarePaginator
    {
        return $post->comments()->paginate(15);
    }

    public function get_children(Comment $comment): LengthAwarePaginator
    {
        return $comment->children()->paginate(15);
    }

    public function get_parent(Comment $comment): LengthAwarePaginator
    {
        return $comment->parent()->paginate(15);
    }

    public function show(Comment $comment): Application|ResponseFactory|Response
    {
        return response($comment, ResponseHttp::HTTP_OK);
    }

    /**
     * @param StoreRequest $request
     * @param Post $post
     * @return Response|Application|ResponseFactory
     */
    public function store(StoreRequest $request, Post $post): Response|Application|ResponseFactory
    {
        $cleanData = $request->validated();

        $comment = new Comment();

        $comment->content = $cleanData['content'];
        $comment->comment_id = $cleanData['comment_id'];
        $comment->post_id = $post->id;

        $request->user()->comments()->save($comment);

        $response = [
            'message' => 'Comment added',
            'object' => $comment,
        ];

        return response($response, ResponseHttp::HTTP_CREATED);
    }

    /**
     * @param UpdateRequest $request
     * @param Comment $comment
     * @return Response|Application|ResponseFactory
     * @throws ValidationException
     */
    public function update(UpdateRequest $request, Comment $comment): Response|Application|ResponseFactory
    {
        $validator = Validator::make($request->all(), $request->rules());

        if ($validator->fails()) {
            throw ValidationException::withMessages((array)$validator->errors());
        }

        $comment->update($request->all());

        $response = [
            'message' => 'Your comment updated'
        ];

        return response($response, ResponseHttp::HTTP_OK);
    }

    /**
     * Remove the specified comment from storage.
     */
    public function destroy(Comment $comment): Response|Application|ResponseFactory
    {
        if ($comment->deleteOrFail() === false) {
            $response = [
                'message' => "Couldn't delete the comment"
            ];

            return response($response, ResponseHttp::HTTP_BAD_REQUEST);
        }

        $response = [
            'message' => 'The comment deleted'
        ];

        return response($response, ResponseHttp::HTTP_NO_CONTENT);
    }
}
