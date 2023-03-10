<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobCategory extends Model
{
    use HasFactory;

    protected $table = 'job_categories';

    protected $fillable = [
        'title',
        'link',
    ];

    public function jobAds(): HasMany
    {
        return $this->hasMany(JobAd::class, 'job_category_id', 'id');
    }

    public function companies(): HasMany
    {
        return $this->hasMany(Company::class, 'job_category_id', 'id');
    }
}
