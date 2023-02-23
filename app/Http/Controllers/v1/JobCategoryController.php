<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobCategory\StoreRequest;
use App\Http\Requests\JobCategory\UpdateRequest;
use App\Models\JobCategory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
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

        $jobCategory->save();

        $response = [
            'message' => 'job category added',
            'object' => $jobCategory,
        ];

        return response($response, ResponseHttp::HTTP_CREATED);
    }

    /**
     * Display the specified job category
     */
    public function show(JobCategory $job_category): Application|ResponseFactory|Response
    {
        return response($job_category, ResponseHttp::HTTP_OK);
    }

    /**
     * Update the specified Job ad in storage.
     * @throws ValidationException
     */
    public function update(UpdateRequest $request, JobCategory $job_category): Response|Application|ResponseFactory
    {
        $validator = Validator::make($request->all(), $request->rules());

        if ($validator->fails()) {
            throw ValidationException::withMessages((array)$validator->errors());
        }

        $job_category->update($request->all());

        $response = [
            'message' => 'Job category updated',
        ];

        return response($response, ResponseHttp::HTTP_OK);
    }

    /**
     * Remove the specified job ad from storage.
     */
    public function destroy(JobCategory $job_category): Response|Application|ResponseFactory
    {
        if ($job_category->deleteOrFail() === false) {
            $response = [
                'message' => "Couldn't delete the Job Category"
            ];

            return response($response, ResponseHttp::HTTP_BAD_REQUEST);
        }

        $response = [
            'message' => 'Job Category deleted'
        ];

        return response($response, ResponseHttp::HTTP_NO_CONTENT);
    }
}
