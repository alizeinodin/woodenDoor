<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class CommentController extends Controller
{
    public function index(): Collection
    {
        return Comment::all();
    }

    public function get_comments(Post $post): LengthAwarePaginator
    {
        return $post->comments()->paginate(15);
    }
}
