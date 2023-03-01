<?php

namespace App\Models;

use App\Enum\VerificationCodeStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerificationCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'code',
        'verify',
        'expires_at',
    ];

    protected $hidden = [
        'code'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'verify' => VerificationCodeStatus::class,
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
