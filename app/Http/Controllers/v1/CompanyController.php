<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\StoreRequest;
use App\Http\Requests\Company\UpdateRequest;
use App\Models\Company;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseHttp;

class CompanyController extends Controller
{
    /**
     * Display a listing of the
     * companies 15 pagination
     */
    public function index()
    {
        return Company::paginate(15);
    }

    /**
     * Get the companies of a user which is an employer
     *
     * @param Request $request
     * @return mixed
     */
    public function my_companies(Request $request): mixed
    {
        return $request->user()->employer->companies()->paginate(15);
    }

    /**
     * Store a newly created company in storage.
     */
    public function store(StoreRequest $request): Application|ResponseFactory|Response
    {
        $cleanData = $request->validated();

        $cleanData['file'] = $request->input('file') !== null ?
            (new UploadController())->storeImage($request['file']) : null;


        $this->add_company($cleanData, $request->user());

        $response = [
            'message' => 'Your company added'
        ];

        return response($response, ResponseHttp::HTTP_CREATED);
    }

    public function add_company(array $cleanData, User $user): Company
    {
        $company = new Company();

        $company->persian_name = $cleanData['persian_name'];
        $company->english_name = $cleanData['english_name'];
        $company->logo_path = $cleanData['file'];
        $company->tel = $cleanData['tel'] ?? null;
        $company->address = $cleanData['address'] ?? null;
        $company->website = $cleanData['website'] ?? null;
        $company->about_company = $cleanData['about_company'] ?? null;
        $company->nick_name = $cleanData['nick_name'];
        $company->job_category_id = $cleanData['job_category_id'] ?? 1;

        $user->employer->companies()->save($company);

        return $company;
    }

    /**
     * Display the specified company.
     */
    public function show(Company $company): Application|ResponseFactory|Response
    {
        return response($company, ResponseHttp::HTTP_OK);
    }

    /**
     * Update the specified company in storage.
     * @throws ValidationException
     */
    public function update(UpdateRequest $request, Company $company): Response|Application|ResponseFactory
    {
        $validator = Validator::make($request->all(), $request->rules());

        if ($validator->fails()) {
            throw ValidationException::withMessages((array)$validator->errors());
        }

        if ($request->hasFile('file')) {
            $request['file'] = $request->input('file') !== null ?
                (new UploadController())->storeImage($request['file']) : null;
        }

        $company->update($request->all());

        $response = [
            'message' => 'Your company updated'
        ];

        return response($response, ResponseHttp::HTTP_OK);
    }

    /**
     * Remove the specified company from storage.
     */
    public function destroy(Company $company): Response|Application|ResponseFactory
    {
        if ($company->deleteOrFail() === false) {
            $response = [
                'message' => "Couldn't delete the company"
            ];

            return response($response, ResponseHttp::HTTP_BAD_REQUEST);
        }

        $response = [
            'message' => 'Your company deleted'
        ];

        return response($response, ResponseHttp::HTTP_NO_CONTENT);
    }
}
