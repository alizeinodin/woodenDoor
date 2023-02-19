<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static create()
 */
class Employee extends Model
{
    protected $table = 'employees';

    protected $fillable = [
        'province',
        'address',
        'about_me',
        'min_salary',
        'military_status',
        'job_position_title',
        'job_position_status',
    ];

    /**
     * Get the user that owns the employee
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    use HasFactory;
}
