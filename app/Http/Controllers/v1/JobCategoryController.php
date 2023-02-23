<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\JobCategory;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

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



}
