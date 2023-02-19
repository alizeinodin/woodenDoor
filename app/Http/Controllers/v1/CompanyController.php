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

        $this->add_company($cleanData, $request->user());

        $response = [
            'message' => 'Your company added'
        ];

        return response($response, ResponseHttp::HTTP_CREATED);
    }

    public function add_company(array $cleanData, User $user)
    {
        $company = new Company();

        $company->persian_name = $cleanData['persian_name'];
        $company->english_name = $cleanData['english_name'];
        $company->logo_path = $cleanData['logo_path'] ?? null;
        $company->tel = $cleanData['tel'] ?? null;
        $company->address = $cleanData['address'] ?? null;
        $company->website = $cleanData['website'] ?? null;
        $company->about_company = $cleanData['about_company'] ?? null;
        $company->nick_name = $cleanData['nick_name'];

        $user->employer->companies()->save($company);
    }

    /**
     * Display the specified company.
     */
    public function show(string $id): Response
    {
        return Company::find($id);
    }

    /**
     * Update the specified company in storage.
     */
    public function update(UpdateRequest $request, Company $company): Response|Application|ResponseFactory
    {
        $cleanData = $request->validated();

        $company->update([
            'persian_name' => $cleanData['persian_name'],
            'english_name' => $cleanData['english_name'],
            'logo_path' => $cleanData['logo_path'],
            'tel' => $cleanData['tel'],
            'address' => $cleanData['address'],
            'website' => $cleanData['website'],
            'about_company' => $cleanData['about_company'],
        ]);

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
