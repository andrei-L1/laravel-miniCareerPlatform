<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Job;
use App\Models\Application;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property User $user
 */
class JobSeekerController extends Controller
{
    /**
     * Display the job seeker's profile.
     */
    public function index(): View
    {
        /** @var User $user */
        $user = Auth::user();
        if (!$user->isJobSeeker()) {
            abort(403, 'Unauthorized action.');
        }
        return view('job_seekers.show', compact('user'));
    }

    /**
     * Show the form for editing the authenticated job seeker's info.
     */
    public function edit(): View
    {
        /** @var User $user */
        $user = Auth::user();
        if (!$user->isJobSeeker()) {
            abort(403, 'Unauthorized action.');
        }
        return view('job_seekers.edit', compact('user'));
    }

    /**
     * Update the authenticated job seeker's info.
     */
    public function update(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();
        if (!$user->isJobSeeker()) {
            abort(403, 'Unauthorized action.');
        }

        // Validate the form data
        $rules = [];
        if ($user->user_type === 'student') {
            $rules = [
                'student_id' => 'required|string|max:255',
                'graduation_year' => 'required|digits:4|integer|min:1900|max:' . (date('Y') + 10),
            ];
        } else {
            $rules = [
                'current_job' => 'required|string|max:255',
            ];
        }

        $validated = $request->validate($rules);

        // Update the user's information
        $user->update($validated);

        return redirect()->route('job_seeker.profile.edit')->with('success', 'Profile updated successfully.');
    }

    /**
     * Display available job opportunities for job seekers.
     */
    public function opportunities(): View
    {
        /** @var User $user */
        $user = Auth::user();
        if (!$user->isJobSeeker()) {
            abort(403, 'Unauthorized action.');
        }

        $jobs = Job::where('status', 'active')
            ->with('employer')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('job_seekers.opportunities', compact('jobs'));
    }

    /**
     * Display career resources for job seekers.
     */
    public function resources(): View
    {
        /** @var User $user */
        $user = Auth::user();
        if (!$user->isJobSeeker()) {
            abort(403, 'Unauthorized action.');
        }
        return view('job_seekers.resources');
    }

    /**
     * Display saved jobs for the job seeker.
     */
    public function savedJobs(): View
    {
        /** @var User $user */
        $user = Auth::user();
        if (!$user->isJobSeeker()) {
            abort(403, 'Unauthorized action.');
        }
        
        $savedJobs = $user->savedJobs()
            ->with(['employer'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('job_seekers.saved_jobs', compact('savedJobs'));
    }

    /**
     * Display job applications for the job seeker.
     */
    public function applications(): View
    {
        /** @var User $user */
        $user = Auth::user();
        if (!$user->isJobSeeker()) {
            abort(403, 'Unauthorized action.');
        }
        
        $applications = $user->applications()->with('job')->paginate(10);
        return view('job_seekers.applications', compact('applications'));
    }

    /**
     * Display job details for job seekers.
     */
    public function showJob(Job $job): View
    {
        /** @var User $user */
        $user = Auth::user();
        if (!$user->isJobSeeker()) {
            abort(403, 'Unauthorized action.');
        }

        $hasApplied = $user->applications()->where('job_id', $job->id)->exists();
        $isSaved = $user->savedJobs()->where('job_id', $job->id)->exists();

        return view('job_seekers.jobs.show', compact('job', 'hasApplied', 'isSaved'));
    }

    /**
     * Save a job for the authenticated user.
     */
    public function saveJob(Job $job): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();
        if (!$user->isJobSeeker()) {
            abort(403, 'Unauthorized action.');
        }

        // Check if job is already saved
        if ($user->savedJobs()->where('job_id', $job->id)->exists()) {
            return redirect()->back()->with('error', 'You have already saved this job.');
        }

        $user->savedJobs()->attach($job->id);
        return redirect()->back()->with('success', 'Job saved successfully.');
    }

    /**
     * Remove a job from the user's saved jobs.
     */
    public function unsaveJob(Job $job): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();
        if (!$user->isJobSeeker()) {
            abort(403, 'Unauthorized action.');
        }

        $user->savedJobs()->detach($job->id);
        return redirect()->back()->with('success', 'Job removed from saved jobs.');
    }

    /**
     * Apply for a job.
     */
    public function applyForJob(Job $job): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();
        if (!$user->isJobSeeker()) {
            abort(403, 'Unauthorized action.');
        }

        // Check if user has already applied
        if ($job->applications()->where('user_id', $user->id)->exists()) {
            return redirect()->back()->with('error', 'You have already applied for this job.');
        }

        // Create new application
        $job->applications()->create([
            'user_id' => $user->id,
            'status' => 'Pending'
        ]);

        return redirect()->back()->with('success', 'Application submitted successfully.');
    }
} 