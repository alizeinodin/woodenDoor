<?php

namespace App\Models;

use App\Enum\Reaction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';

    protected $fillable = [
        'title',
        'description',
        'content',
        'post_status',
        'comment_status',
        'score',
        'uri',
        'index_image',
    ];

    public function post_category(): BelongsTo
    {
        return $this->belongsTo(PostCategory::class, 'category_id', 'id');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the users which reacted to this post
     *
     * @return BelongsToMany
     */
    public function reacted_users(): BelongsToMany
    {
        return $this->belongsToMany(ReactionPost::class, 'reaction_posts');
    }

    public function getTotalLikesAttributes(): int
    {
        return $this->hasMany(ReactionPost::class)
            ->where(['react' => Reaction::LIKE])
            ->count();
    }

    public function getTotalDislikesAttributes(): int
    {
        return $this->hasMany(ReactionPost::class)
            ->where(['react' => Reaction::DISLIKE])
            ->count();
    }
}
