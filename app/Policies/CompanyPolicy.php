<?php

namespace App\Policies;

use App\Http\Requests\Company\StoreRequest;

class CompanyPolicy
{
    public function create(StoreRequest $request): bool
    {
        return $request->user()->role == 'Employer';
    }
}
