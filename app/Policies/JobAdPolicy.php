<?php

namespace App\Policies;

use App\Http\Requests\JobAd\StoreRequest;
use App\Http\Requests\JobAd\UpdateRequest;
use App\Models\JobAd;
use Illuminate\Http\Request;

class JobAdPolicy
{
    public function create(StoreRequest $request): bool
    {
        return $request->user()->role == 'Employer';
    }

    public function update(UpdateRequest $request, JobAd $jobAd): bool
    {
        $result = false;

        $companies = $request->user()->companies;

        foreach ($companies as $company) {
            if ($jobAd->company == $company)
                $request = true;
        }

        return ($request->user()->role == 'Employer') && ($result);
    }

    public function delete(Request $request, JobAd $jobAd): bool
    {
        $result = false;

        $companies = $request->user()->companies;

        foreach ($companies as $company) {
            if ($jobAd->company == $company)
                $request = true;
        }

        return ($request->user()->role == 'Employer') && ($result);
    }
}
