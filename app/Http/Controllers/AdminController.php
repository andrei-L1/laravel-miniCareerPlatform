<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Job;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    private function checkAdmin()
    {
        if (!Auth::check() || Auth::user()->user_type !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
    }

    public function dashboard()
    {
        $this->checkAdmin();
        
        $data = [
            'totalUsers' => User::count(),
            'activeJobs' => Job::where('status', 'active')->count(),
            'totalApplications' => Application::count(),
        ];

        return view('dashboard', $data);
    }

    public function users()
    {
        $this->checkAdmin();
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function jobs()
    {
        $this->checkAdmin();
        $jobs = Job::with('employer')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('admin.jobs.index', compact('jobs'));
    }

    public function showJob(Job $job)
    {
        $this->checkAdmin();
        return view('admin.jobs.show', compact('job'));
    }

    public function updateJobStatus(Request $request, Job $job)
    {
        $this->checkAdmin();
        $validated = $request->validate([
            'status' => 'required|in:Active,Closed'
        ]);

        $job->update($validated);

        return redirect()->back()->with('success', 'Job status updated successfully');
    }

    public function deleteJob(Job $job)
    {
        $this->checkAdmin();
        $job->delete();
        return redirect()->route('admin.jobs')->with('success', 'Job deleted successfully');
    }

    public function resources()
    {
        $this->checkAdmin();
        return view('admin.resources.index');
    }

    public function settings()
    {
        $this->checkAdmin();
        return view('admin.settings.index');
    }

    public function updateUser(Request $request, $id)
    {
        $this->checkAdmin();
        try {
            $user = User::findOrFail($id);
            
            // Debug incoming request data
            Log::info('Update User Request:', $request->all());
            
            // Basic validation rules
            $rules = [
                'first_name' => 'sometimes|required|string|max:255',
                'last_name' => 'sometimes|required|string|max:255',
                'email' => 'sometimes|required|email|unique:users,email,' . $id,
                'user_type' => 'sometimes|required|in:student,professional,employer,admin',
            ];

            // Add conditional validation rules based on user type
            if ($request->has('user_type') && $request->user_type === 'student') {
                $rules['student_id'] = 'required|string|max:255';
                $rules['graduation_year'] = 'required|integer|min:2000|max:2100';
            } elseif ($request->has('user_type') && $request->user_type === 'employer') {
                $rules['company_name'] = 'required|string|max:255';
            } elseif ($request->has('user_type') && $request->user_type === 'professional') {
                $rules['current_job'] = 'required|string|max:255';
            }

            $validated = $request->validate($rules);

            // Prepare update data with only changed fields
            $updateData = [];

            // Only update fields that are present in the request
            if ($request->filled('first_name')) {
                $updateData['first_name'] = $validated['first_name'];
            }
            if ($request->filled('last_name')) {
                $updateData['last_name'] = $validated['last_name'];
            }
            if ($request->filled('email')) {
                $updateData['email'] = $validated['email'];
            }
            if ($request->filled('user_type')) {
                $updateData['user_type'] = $validated['user_type'];
                
                // Handle type-specific fields only if user type is changing
                if ($validated['user_type'] === 'student') {
                    $updateData['student_id'] = $validated['student_id'];
                    $updateData['graduation_year'] = $validated['graduation_year'];
                    $updateData['company_name'] = null;
                    $updateData['current_job'] = null;
                } elseif ($validated['user_type'] === 'employer') {
                    $updateData['company_name'] = $validated['company_name'];
                    $updateData['student_id'] = null;
                    $updateData['graduation_year'] = null;
                    $updateData['current_job'] = null;
                } elseif ($validated['user_type'] === 'professional') {
                    $updateData['current_job'] = $validated['current_job'];
                    $updateData['student_id'] = null;
                    $updateData['graduation_year'] = null;
                    $updateData['company_name'] = null;
                } else {
                    // Admin type - clear all type-specific fields
                    $updateData['student_id'] = null;
                    $updateData['graduation_year'] = null;
                    $updateData['company_name'] = null;
                    $updateData['current_job'] = null;
                }
            } else {
                // If user type is not changing, only update type-specific fields if they are present
                if ($request->filled('student_id')) {
                    $updateData['student_id'] = $validated['student_id'];
                }
                if ($request->filled('graduation_year')) {
                    $updateData['graduation_year'] = $validated['graduation_year'];
                }
                if ($request->filled('company_name')) {
                    $updateData['company_name'] = $validated['company_name'];
                }
                if ($request->filled('current_job')) {
                    $updateData['current_job'] = $validated['current_job'];
                }
            }

            // Debug update data
            Log::info('Update Data:', $updateData);

            // Only update if there are changes
            if (!empty($updateData)) {
                $updated = $user->update($updateData);
                Log::info('Update Result:', ['success' => $updated]);
                
                return response()->json([
                    'success' => true,
                    'message' => 'User updated successfully',
                    'data' => $updateData
                ]);
            } else {
                return response()->json([
                    'success' => true,
                    'message' => 'No changes to update'
                ]);
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation Error:', $e->errors());
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Update Error:', ['message' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error updating user: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteUser($id)
    {
        $this->checkAdmin();
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'User deleted successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Delete Error:', ['message' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error deleting user: ' . $e->getMessage()
            ], 500);
        }
    }
}
