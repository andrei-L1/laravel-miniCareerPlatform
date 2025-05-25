<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - CareerCON</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen">
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <span class="text-xl font-bold">CareerCON</span>
                </div>
                <div class="flex items-center">
                    <span class="mr-4">Welcome, {{ auth()->user()->full_name }}</span>
                    <form action="{{ route('auth.destroy') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-red-500 hover:text-red-700">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="border-4 border-dashed border-gray-200 rounded-lg p-6">
                <h1 class="text-2xl font-bold mb-6">Welcome to your Dashboard</h1>
                
                @if(auth()->user()->user_type === 'admin')
                    <div class="space-y-4">
                        <!-- User Management Section -->
                        <div class="bg-white p-4 rounded-lg shadow">
                            <h2 class="text-xl font-semibold mb-2">User Management</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="mb-2">Manage all platform users</p>
                                    <a href="{{ route('admin.users') }}" class="text-blue-500 hover:text-blue-700">View All Users →</a>
                                </div>
                                <div>
                                    <p class="mb-2">User roles and permissions</p>
                                    <a href="{{ route('admin.users') }}" class="text-blue-500 hover:text-blue-700">Manage Roles →</a>
                                </div>
                            </div>
                        </div>

                        <!-- Platform Statistics Section -->
                        <div class="bg-white p-4 rounded-lg shadow">
                            <h2 class="text-xl font-semibold mb-2">Platform Statistics</h2>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <p class="font-medium">Total Users</p>
                                    <p class="text-2xl font-bold">{{ $totalUsers ?? 0 }}</p>
                                </div>
                                <div>
                                    <p class="font-medium">Active Jobs</p>
                                    <p class="text-2xl font-bold">{{ $activeJobs ?? 0 }}</p>
                                </div>
                                <div>
                                    <p class="font-medium">Applications</p>
                                    <p class="text-2xl font-bold">{{ $totalApplications ?? 0 }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Content Management Section -->
                        <div class="bg-white p-4 rounded-lg shadow">
                            <h2 class="text-xl font-semibold mb-2">Content Management</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="mb-2">Manage job postings</p>
                                    <a href="{{ route('admin.jobs') }}" class="text-blue-500 hover:text-blue-700">Review Jobs →</a>
                                </div>
                                <div>
                                    <p class="mb-2">Career resources</p>
                                    <a href="{{ route('admin.resources') }}" class="text-blue-500 hover:text-blue-700">Manage Resources →</a>
                                </div>
                            </div>
                        </div>

                        <!-- System Settings Section -->
                        <div class="bg-white p-4 rounded-lg shadow">
                            <h2 class="text-xl font-semibold mb-2">System Settings</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="mb-2">Platform configuration</p>
                                    <a href="{{ route('admin.settings') }}" class="text-blue-500 hover:text-blue-700">System Settings →</a>
                                </div>
                                <div>
                                    <p class="mb-2">Email templates</p>
                                    <a href="{{ route('admin.settings') }}" class="text-blue-500 hover:text-blue-700">Manage Templates →</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif(auth()->user()->isJobSeeker())
                    <div class="space-y-4">
                        {{-- Profile Information --}}
                        <div class="bg-white p-4 rounded-lg shadow">
                            <h2 class="text-xl font-semibold mb-2">Profile Information</h2>
                            @if(auth()->user()->user_type === 'student')
                                <p><span class="font-medium">Student ID:</span> {{ auth()->user()->student_id }}</p>
                                <p><span class="font-medium">Graduation Year:</span> {{ auth()->user()->graduation_year }}</p>
                            @else
                                <p><span class="font-medium">Current Job:</span> {{ auth()->user()->current_job }}</p>
                            @endif
                        </div>

                        {{-- Job Opportunities --}}
                        <div class="bg-white p-4 rounded-lg shadow">
                            <h2 class="text-xl font-semibold mb-2">Available Opportunities</h2>
                            <p>Browse and apply for jobs</p>
                            <a href="{{ route('job_seeker.opportunities') }}" class="text-blue-500 hover:text-blue-700">View Opportunities →</a>
                        </div>

                        {{-- Career Resources --}}
                        <div class="bg-white p-4 rounded-lg shadow">
                            <h2 class="text-xl font-semibold mb-2">Career Resources</h2>
                            <p>Access resume templates and interview tips</p>
                            <a href="{{ route('job_seeker.resources') }}" class="text-blue-500 hover:text-blue-700">View Resources →</a>
                        </div>

                        {{-- Saved Jobs --}}
                        <div class="bg-white p-4 rounded-lg shadow">
                            <h2 class="text-xl font-semibold mb-2">Saved Jobs</h2>
                            <p>View your saved job listings</p>
                            <a href="{{ route('job_seeker.saved_jobs') }}" class="text-blue-500 hover:text-blue-700">View Saved Jobs →</a>
                        </div>

                        {{-- Applications --}}
                        <div class="bg-white p-4 rounded-lg shadow">
                            <h2 class="text-xl font-semibold mb-2">My Applications</h2>
                            <p>Track your job applications</p>
                            <a href="{{ route('job_seeker.applications') }}" class="text-blue-500 hover:text-blue-700">View Applications →</a>
                        </div>
                    </div>
                @elseif(auth()->user()->user_type === 'employer')
                    <div class="space-y-4">
                        {{-- ✅ Company Info --}}
                        <div class="bg-white p-4 rounded-lg shadow">
                            <h2 class="text-xl font-semibold mb-2">Company Profile</h2>
                            <p><span class="font-medium">Company:</span> {{ auth()->user()->company_name }}</p>
                        </div>

                        {{-- ✅ Job Postings --}}
                        <div class="bg-white p-4 rounded-lg shadow">
                            <h2 class="text-xl font-semibold mb-2">Job Postings</h2>
                            <p>Manage your job listings</p>
                            <a href="{{ route('employer.jobs.index') }}" class="text-blue-500 hover:text-blue-700">View Postings →</a>

                        </div>

                        {{-- ✅ Candidate Search (future feature) --}}
                        <div class="bg-white p-4 rounded-lg shadow">
                            <h2 class="text-xl font-semibold mb-2">Candidate Search</h2>
                            <p>Find qualified candidates</p>
                            <a href="#" class="text-blue-500 hover:text-blue-700">Search Candidates →</a>
                        </div>
                    </div>
                @else
                    <div class="space-y-4">
                        <div class="bg-white p-4 rounded-lg shadow">
                            <h2 class="text-xl font-semibold mb-2">Welcome to CareerCON</h2>
                            <p>You are logged in as a {{ auth()->user()->user_type }} user.</p>
                            <p>Your account is being set up. Please contact support if you need assistance.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </main>
</body>
</html> 