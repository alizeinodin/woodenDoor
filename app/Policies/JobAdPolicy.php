<?php

namespace App\Policies;

use App\Http\Requests\JobAd\StoreRequest;

class JobAdPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function create(StoreRequest $request): bool
    {
        return $request->user()->role == 'Employer';
    }
}
