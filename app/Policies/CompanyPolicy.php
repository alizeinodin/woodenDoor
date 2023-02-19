<?php

namespace App\Policies;

use App\Http\Requests\Company\StoreRequest;
use App\Http\Requests\Company\UpdateRequest;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyPolicy
{
    public function create(StoreRequest $request): bool
    {
        return $request->user()->role == 'Employer';
    }

    public function update(UpdateRequest $request, Company $company): bool
    {
        return
            ($request->user()->role == 'Employer')
            and
            (Company::where('employer_id', $request->user()->employer() == $company->employer()));
    }


    public function delete(Request $request, Company $company): bool
    {
        return
            ($request->user()->role == 'Employer')
            and
            (Company::where('employer_id', $request->user()->employer() == $company->employer()));
    }
}
