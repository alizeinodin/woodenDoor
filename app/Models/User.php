<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * @method static create(array $array)
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'email',
        'phone',
        'sex',
        'married',
        'birth_year',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'birth_year' => 'datetime',
    ];

    /**
     * Get the employee associated with the user
     *
     * @return HasOne
     */
    public function employee(): HasOne
    {
        return $this->hasOne(Employee::class);
    }

    /**
     * Get the employer associated with the user
     *
     * @return HasOne
     */
    public function employer(): HasOne
    {
        return $this->hasOne(Employer::class);
    }

    /**
     * Get the author associated with the user
     *
     * @return HasOne
     */
    public function author(): HasOne
    {
        return $this->hasOne(Author::class, 'user_id', 'id');
    }

    /**
     * Get the comments of user
     *
     * @return HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the reaction's of a user to posts
     *
     * @return BelongsToMany
     */
    public function reactions(): BelongsToMany
    {
        return $this->belongsToMany(ReactionPost::class, 'reaction_posts');
    }

    public function storePosts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'store_posts', 'id', 'post_id');
    }
}
