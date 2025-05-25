<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class SavedJob extends Pivot
{
    protected $table = 'saved_jobs';

    protected $fillable = [
        'user_id',
        'job_id'
    ];

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
} 