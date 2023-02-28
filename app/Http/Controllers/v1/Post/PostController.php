<?php

namespace App\Http\Controllers\v1\Post;

use App\Http\Controllers\Controller;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the
     * post 15 pagination
     */
    public function index()
    {
        return Post::paginate(15);
    }
}
