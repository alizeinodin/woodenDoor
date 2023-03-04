<?php

namespace App\Http\Controllers\v1\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostCategory\StoreRequest;
use App\Http\Requests\PostCategory\UpdateRequest;
use App\Models\PostCategory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
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

    public function show_posts(PostCategory $postCategory): LengthAwarePaginator
    {
        return $postCategory->posts()->paginate(15);
    }

    public function store(StoreRequest $request): Response|Application|ResponseFactory
    {
        $cleanData = $request->validated();

        $postCategory = new PostCategory();

        $postCategory->title = $cleanData['title'];
        $postCategory->description = $cleanData['description'] ?? null;
        $postCategory->link = $cleanData['link'] ?? Str::slug($cleanData['title']);

        $postCategory->save();

        $response = [
            'message' => 'Category added',
            'object' => $postCategory,
        ];

        return response($response, ResponseHttp::HTTP_CREATED);
    }

    /**
     * Update the specified Job ad in storage.
     * @throws ValidationException
     */
    public function update(UpdateRequest $request, PostCategory $post_category): Response|Application|ResponseFactory
    {
        $validator = Validator::make($request->all(), $request->rules());

        if ($validator->fails()) {
            throw ValidationException::withMessages((array)$validator->errors());
        }

        $post_category->update($request->all());

        $response = [
            'message' => 'Category updated',
        ];

        return response($response, ResponseHttp::HTTP_OK);
    }

    /**
     * Remove the specified job ad from storage.
     */
    public function destroy(PostCategory $post_category): Response|Application|ResponseFactory
    {
        if ($post_category->deleteOrFail() === false) {
            $response = [
                'message' => "Couldn't delete the Category"
            ];

            return response($response, ResponseHttp::HTTP_BAD_REQUEST);
        }

        $response = [
            'message' => 'Category deleted'
        ];

        return response($response, ResponseHttp::HTTP_NO_CONTENT);
    }

}
