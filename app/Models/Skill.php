<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category'
    ];

    protected $casts = [
        'created_at' => 'datetime'
    ];

    /**
     * Get the users who have this skill.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_skills')
            ->withPivot('proficiency')
            ->withTimestamps();
    }

    /**
     * Get the jobs that require this skill.
     */
    public function jobs(): BelongsToMany
    {
        return $this->belongsToMany(Job::class, 'job_skills')
            ->withTimestamps();
    }
} 