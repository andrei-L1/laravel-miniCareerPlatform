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
        
        $savedJobs = $user->savedJobs()->paginate(10);
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
} 