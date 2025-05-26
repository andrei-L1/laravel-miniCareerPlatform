<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    // Table name (optional if it's `jobs` by default)
    protected $table = 'jobs';

    // Fields that are mass assignable
    protected $fillable = [
        'title',
        'location',
        'description',
        'employer_id', // Foreign key to user
        'status',
        'salary',
        'type'
    ];

    // Relationship: Each job belongs to an employer (user)
    public function employer()
    {
        return $this->belongsTo(User::class, 'employer_id')->withDefault([
            'company_name' => 'Unknown Company'
        ]);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
