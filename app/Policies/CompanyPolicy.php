<?php

namespace App\Policies;

use App\Http\Requests\Company\StoreRequest;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyPolicy
{
    public function create(StoreRequest $request): bool
    {
        return $request->user()->role == 'Employer';
    }

    public function update(Request $request, Company $company): bool
    {
        return
            ($request->user()->role == 'Employer')
            and
            (Company::where('employer_id', $request->user()->employer() == $company->employer()));
    }
}
