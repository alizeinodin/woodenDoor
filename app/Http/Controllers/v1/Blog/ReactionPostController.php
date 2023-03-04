<?php

namespace App\Http\Controllers\v1\Blog;

use App\Enum\Reaction;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReactionPost\StoreRequest;
use App\Models\ReactionPost;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseHttp;

class ReactionPostController extends Controller
{
    public function index()
    {
        return ReactionPost::paginate(15);
    }

    public function store(StoreRequest $request): Response|Application|ResponseFactory
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

    public function destroy(ReactionPost $reaction): Response|Application|ResponseFactory
    {

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
}
