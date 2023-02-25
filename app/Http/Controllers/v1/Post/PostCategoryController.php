<?php

namespace App\Http\Controllers\v1\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostCategory\StoreRequest;
use App\Models\PostCategory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response as ResponseHttp;

class PostCategoryController extends Controller
{
    /**
     * Display a listing of the
     * post categories 15 pagination
     */
    public function index()
    {
        return PostCategory::paginate(15);
    }

    public function store(StoreRequest $request): Response|Application|ResponseFactory
    {
        $cleanData = $request->validated();

        $postCategory = new PostCategory();

        $postCategory->title = $cleanData['title'];
        $postCategory->description = $cleanData['description'];
        $postCategory->link = $cleanData['link'] ?? Str::slug($cleanData['link']);

        $postCategory->save();

        $response = [
            'message' => 'job category added',
            'object' => $postCategory,
        ];

        return response($response, ResponseHttp::HTTP_CREATED);
    }
}
