<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'job_id',
        'status'
    ];

    protected $casts = [
        'created_at' => 'datetime'
    ];

    /**
     * Get the user who submitted the application.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the job that was applied for.
     */
    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class);
    }
} 