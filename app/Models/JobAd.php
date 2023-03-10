<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobAd extends Model
{
    use HasFactory;

    protected $table = 'job_ads';

    protected $fillable = [
        'title',
        'province',
        'type_of_cooperation',
        'company_id',
        'min_salary',
        'max_salary',
        'description',
        'work_experience',
        'min_education_degree',
        'military_status',
        'sex',
        'status',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function jobCategory(): BelongsTo
    {
        return $this->belongsTo(JobCategory::class, 'job_category_id', 'id');
    }
}
