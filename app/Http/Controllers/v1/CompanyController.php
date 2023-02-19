<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\StoreRequest;
use App\Models\Company;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseHttp;

class CompanyController extends Controller
{
    /**
     * Display a listing of the
     * companies 15 pagination
     */
    public function index(): Response
    {
        return Company::all()->paginate(15);
    }

    /**
     * Get the companies of a user which is an employer
     *
     * @param Request $request
     * @return mixed
     */
    public function my_companies(Request $request): mixed
    {
        return $request->user()->employer()->companies()->paginate(15);
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

    /**
     * Display the specified resource.
     */
    public function show(string $id): Response
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): Response
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        //
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

        $user->employer()->companies($company);
        
        $user->save();
    }
}
