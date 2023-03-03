<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\StoreRequest;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;
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

    public function show(Comment $comment): Application|ResponseFactory|Response
    {
        return response($comment, ResponseHttp::HTTP_OK);
    }

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
}
