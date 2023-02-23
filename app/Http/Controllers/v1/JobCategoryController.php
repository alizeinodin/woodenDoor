<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobCategory\StoreRequest;
use App\Models\JobCategory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseHttp;

class JobCategoryController extends Controller
{
    /**
     * Display a listing of the
     * job categories 15 pagination
     */
    public function index()
    {
        return JobCategory::paginate(15);
    }

    public function showJobAds(JobCategory $category): LengthAwarePaginator
    {
        return $category->jobAds()->paginate(15);
    }

    public function showCompanies(JobCategory $category): LengthAwarePaginator
    {
        return $category->companies()->paginate(15);
    }

    public function store(StoreRequest $request): Response|Application|ResponseFactory
    {
        $cleanData = $request->validated();

        $jobCategory = new JobCategory();

        $jobCategory->name = $cleanData['name'];

        $response = [
            'message' => 'Your job category added',
            'object' => $jobCategory,
        ];

        return response($response, ResponseHttp::HTTP_CREATED);
    }

    /**
     * Display the specified job category
     */
    public function show(JobCategory $category): Application|ResponseFactory|Response
    {
        return response($category, ResponseHttp::HTTP_OK);
    }
}
