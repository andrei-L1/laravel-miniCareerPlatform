<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class JobSkill extends Pivot
{
    protected $table = 'job_skills';

    protected $fillable = [
        'job_id',
        'skill_id'
    ];

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }
} 