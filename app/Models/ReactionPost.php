<?php

namespace App\Models;

use App\Enum\Reaction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReactionPost extends Model
{
    protected $table = 'reaction_posts';

    use HasFactory;

    protected $fillable = [
        'react',
    ];

    protected $casts = [
        'react' => Reaction::class,
    ];
}
