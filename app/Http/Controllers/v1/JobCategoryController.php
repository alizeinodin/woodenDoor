<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\JobCategory;

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

}
