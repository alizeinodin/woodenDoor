<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'persian_name',
        'english_name',
        'logo_path',
        'tel',
        'address',
        'website',
        'number_of_staff',
        'about_company',
        'nick_name',
        'employer_id'
    ];

    public function employer(): BelongsTo
    {
        return $this->belongsTo(Employer::class, 'employer_id', 'user_id');
    }

    public function jobads(): HasMany
    {
        return $this->hasMany(JobAd::class, 'company_id', 'id');
    }
}
