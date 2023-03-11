<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseHttp;

class StorePostController extends Controller
{
    public function storePost(Request $request, Post $post): Response|Application|ResponseFactory
    {
        $post->usersStored()->attach([$request->user()->id]);

        dd($post);

        $response = [
            'message' => 'The post added to your account',
        ];

        return response($response, ResponseHttp::HTTP_OK);
    }

    public function unStorePost(Request $request, Post $post): Response|Application|ResponseFactory
    {
        $post->usersStored()->detach($request->user()->id);

        $response = [
            'message' => 'The post deleted from your account',
        ];

        return response($response, ResponseHttp::HTTP_OK);
    }

    public function getStorePosts(Request $request)
    {
        return $request->user()->storePosts()->paginate(15);
    }

    public function getUsersStored(Post $post): LengthAwarePaginator
    {
        return $post->usersStored()->paginate(15);
    }
}
