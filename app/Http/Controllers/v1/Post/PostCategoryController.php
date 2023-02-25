<?php

namespace App\Http\Controllers\v1\Post;

use App\Http\Controllers\Controller;
use App\Models\PostCategory;

class PostCategoryController extends Controller
{
    /**
     * Display a listing of the
     * post categories 15 pagination
     */
    public function index()
    {
        return PostCategory::paginate(15);
    }
}
