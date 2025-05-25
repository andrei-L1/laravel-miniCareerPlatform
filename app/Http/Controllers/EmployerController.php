<?php

namespace App\Http\Controllers;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
}
