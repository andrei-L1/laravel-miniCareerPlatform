<?php

namespace App\Http\Controllers;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Skill;
use App\Models\Application;

class EmployerController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Job::class, 'job');
    }

    public function index()
    {
        $jobs = Job::where('employer_id', Auth::id())->paginate(10);
        return view('employer.jobs.index', compact('jobs'));
    }

    public function create()
    {
        return view('employer.jobs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'location' => 'required|string|max:255',
            'type' => 'required|string|in:full-time,part-time,contract,internship',
            'salary' => 'required|numeric|min:0',
        ]);

        try {
            // Create the job with all fields including requirements
            $job = Job::create([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'requirements' => $validated['requirements'],
                'location' => $validated['location'],
                'type' => $validated['type'],
                'salary' => $validated['salary'],
                'employer_id' => Auth::id(),
                'status' => 'active'
            ]);

            return redirect()->route('employer.jobs.index')
                ->with('success', 'Job posted successfully!');
        } catch (\Exception $e) {
            Log::error('Job creation failed: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            
            return back()->withInput()
                ->withErrors(['error' => 'Failed to create job: ' . $e->getMessage()]);
        }
    }

    public function show(Job $job)
    {
        return view('employer.jobs.show', compact('job'));
    }

    public function edit(Job $job)
    {
        return view('employer.jobs.edit', compact('job'));
    }

    public function update(Request $request, Job $job)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'location' => 'required|string|max:255',
            'type' => 'required|string|in:full-time,part-time,contract,internship',
            'salary' => 'required|numeric|min:0',
            'status' => 'sometimes|required|string|in:active,inactive,closed',
        ]);

        try {
            // Update the job with all fields including requirements
            $job->update([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'requirements' => $validated['requirements'],
                'location' => $validated['location'],
                'type' => $validated['type'],
                'salary' => $validated['salary'],
                'status' => $validated['status'] ?? $job->status
            ]);

            return redirect()->route('employer.jobs.index')
                ->with('success', 'Job updated successfully!');
        } catch (\Exception $e) {
            Log::error('Job update failed: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            
            return back()->withInput()
                ->withErrors(['error' => 'Failed to update job: ' . $e->getMessage()]);
        }
    }

    public function destroy(Job $job)
    {
        try {
            $job->delete();
            
            return redirect()->route('employer.jobs.index')
                ->with('success', 'Job deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Job deletion failed: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            
            return back()->withErrors(['error' => 'Failed to delete job: ' . $e->getMessage()]);
        }
    }

    public function applications(Job $job)
    {
        $applications = $job->applications()->with('user')->paginate(10);
        return view('employer.jobs.applications', compact('job', 'applications'));
    }

    public function showApplication(Application $application)
    {
        // Ensure the application belongs to one of the employer's jobs
        if ($application->job->employer_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('employer.applications.show', compact('application'));
    }

    public function updateApplication(Request $request, Application $application)
    {
        // Ensure the application belongs to one of the employer's jobs
        if ($application->job->employer_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'status' => 'required|in:Accepted,Rejected'
        ]);

        $application->update($validated);

        return redirect()->back()->with('success', 'Application status updated successfully.');
    }

    public function searchCandidates(Request $request)
    {
        $query = User::whereIn('user_type', ['student', 'professional']);

        // Search by name
        if ($request->has('name')) {
            $query->where(function($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->name . '%')
                  ->orWhere('last_name', 'like', '%' . $request->name . '%');
            });
        }

        // Filter by skills
        if ($request->has('skills')) {
            $skills = explode(',', $request->skills);
            $query->whereHas('skills', function($q) use ($skills) {
                $q->whereIn('name', $skills);
            });
        }

        // Filter by user type (student/professional)
        if ($request->has('user_type')) {
            $query->where('user_type', $request->user_type);
        }

        // Filter by graduation year for students
        if ($request->has('graduation_year')) {
            $query->where('graduation_year', $request->graduation_year);
        }

        // Filter by current job for professionals
        if ($request->has('current_job')) {
            $query->where('current_job', 'like', '%' . $request->current_job . '%');
        }

        $candidates = $query->with(['skills' => function($q) {
            $q->select('name');
        }])->paginate(10);

        // Get all skills for the filter dropdown
        $skills = Skill::orderBy('name')->get();

        return view('employer.candidates.search', compact('candidates', 'skills'));
    }
}
