<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobAd\StoreRequest;
use App\Http\Requests\JobAd\UpdateRequest;
use App\Models\Company;
use App\Models\JobAd;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseHttp;

class JobAdController extends Controller
{
    /**
     * Display a listing of the
     * job ads 15 pagination
     */
    public function index()
    {
        return JobAd::paginate(15);
    }

    /**
     * Get the job ads of a user which is an employer
     *
     * @param Request $request
     * @return mixed
     */
    public function my_jobAds(Request $request): mixed
    {
        return $request->user()->employer->has('companies')->has('jobads')->get();
    }

    /**
     * Store a newly created job ad in storage.
     */
    public function store(StoreRequest $request, Company $company): Response|Application|ResponseFactory
    {
        $cleanData = $request->validated();

        $jobAd = new JobAd();

        $jobAd->title = $cleanData['title'];
        $jobAd->province = $cleanData['province'];
        $jobAd->type_of_cooperation = $cleanData['type_of_cooperation'];
        $jobAd->min_salary = $cleanData['min_salary'] ?? null;
        $jobAd->description = $cleanData['description'];
        $jobAd->work_experience = $cleanData['work_experience'] ?? null;
        $jobAd->min_education_degree = $cleanData['min_education_degree'] ?? null;
        $jobAd->military_status = $cleanData['military_status'] ?? null;
        $jobAd->sex = $cleanData['sex'] ?? null;
        $jobAd->job_category_id = $cleanData['job_ad_category'] ?? 1;

        $jobAd->company()->associate($company)->save();

        $response = [
            'message' => 'Your job ad added',
            'object' => $jobAd,
        ];

        return response($response, ResponseHttp::HTTP_CREATED);
    }


    /**
     * Display the specified job ad.
     */
    public function show(JobAd $jobAd): Application|ResponseFactory|Response
    {
        return response($jobAd, ResponseHttp::HTTP_OK);
    }

    /**
     * Update the specified Job ad in storage.
     * @throws ValidationException
     */
    public function update(UpdateRequest $request, JobAd $jobAd): Response|Application|ResponseFactory
    {
        $validator = Validator::make($request->all(), $request->rules());

        if ($validator->fails()) {
            throw ValidationException::withMessages((array)$validator->errors());
        }

        $jobAd->update($request->all());

        $response = [
            'message' => 'Your Job ad updated'
        ];

        return response($response, ResponseHttp::HTTP_OK);
    }

    /**
     * Remove the specified job ad from storage.
     */
    public function destroy(JobAd $jobAd): Response|Application|ResponseFactory
    {
        if ($jobAd->deleteOrFail() === false) {
            $response = [
                'message' => "Couldn't delete the Job Ad"
            ];

            return response($response, ResponseHttp::HTTP_BAD_REQUEST);
        }

        $response = [
            'message' => 'Your Job Ad deleted'
        ];

        return response($response, ResponseHttp::HTTP_NO_CONTENT);
    }
}
