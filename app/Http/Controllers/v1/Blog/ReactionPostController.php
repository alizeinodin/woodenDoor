<?php

namespace App\Http\Controllers\v1\Blog;

use App\Http\Controllers\Controller;
use App\Models\ReactionPost;

class ReactionPostController extends Controller
{
    public function index()
    {
        return ReactionPost::paginate(15);
    }
}
