<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerificationCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'code'
    ];

    protected $hidden = [
        'code'
    ];

    protected $casts = [
        'expire_at' => 'datetime'
    ];

    /**
     * Scope a query to only include verification codes that have not expired.
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeNotExpired(Builder $query): Builder
    {
        return $query->where('expires_at', '>=', now());
    }
}
