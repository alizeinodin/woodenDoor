<?php

namespace App\Http\Controllers\v1\Blog;

use App\Enum\Reaction;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReactionPost\DeleteReactRequest;
use App\Http\Requests\ReactionPost\StoreRequest;
use App\Models\Post;
use App\Models\ReactionPost;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseHttp;

class ReactionPostController extends Controller
{
    public function index()
    {
        return ReactionPost::paginate(15);
    }

    public function react(StoreRequest $request): Response|Application|ResponseFactory
    {
        $cleanData = $request->validated();

        $react = $cleanData['react'] === 'like' ? Reaction::LIKE : Reaction::DISLIKE;

        $reaction = ReactionPost::upsert([
            'react' => $react,
            'post_id' => $cleanData['post_id'],
            'user_id' => $request->user()->id,
        ], ['post_id', 'user_id']);


        $response = [
            'message' => 'Reaction recorded',
            'object' => $reaction,
        ];

        return response($response, ResponseHttp::HTTP_CREATED);
    }

    public function delete_react(DeleteReactRequest $request): Response|Application|ResponseFactory
    {
        $cleanData = $request->validated();

        $reaction = ReactionPost::where([
            'user_id' => $request->user()->id,
            'post_id' => $cleanData['post_id'],
        ])->first();

        if ($reaction->deleteOrFail() === false) {
            $response = [
                'message' => "Couldn't delete the reaction"
            ];

            return response($response, ResponseHttp::HTTP_BAD_REQUEST);
        }

        $response = [
            'message' => 'Your reaction deleted'
        ];

        return response($response, ResponseHttp::HTTP_NO_CONTENT);
    }

    public function likesOfPost(Post $post): LengthAwarePaginator
    {
        return $post->reacted_users()->where(['react' => Reaction::LIKE])->paginate(15);
    }

    public function disLikesOfPost(Post $post): LengthAwarePaginator
    {
        return $post->reacted_users()->where(['react' => Reaction::DISLIKE])->paginate(15);
    }
}
