<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Details - CareerCON</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen">
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-xl font-bold">CareerCON</a>
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

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold">Job Details</h1>
                    <div>
                        <a href="{{ route('admin.jobs') }}" class="text-blue-500 hover:text-blue-700 mr-4">← Back to Jobs</a>
                        <a href="{{ route('dashboard') }}" class="text-blue-500 hover:text-blue-700">← Back to Dashboard</a>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h2 class="text-xl font-semibold mb-4">Job Information</h2>
                        <div class="space-y-4">
                            <div>
                                <h3 class="font-medium text-gray-700">Title</h3>
                                <p class="mt-1">{{ $job->title }}</p>
                            </div>
                            <div>
                                <h3 class="font-medium text-gray-700">Company</h3>
                                <p class="mt-1">{{ $job->employer->company_name }}</p>
                            </div>
                            <div>
                                <h3 class="font-medium text-gray-700">Location</h3>
                                <p class="mt-1">{{ $job->location }}</p>
                            </div>
                            <div>
                                <h3 class="font-medium text-gray-700">Salary</h3>
                                <p class="mt-1">{{ $job->salary }}</p>
                            </div>
                            <div>
                                <h3 class="font-medium text-gray-700">Status</h3>
                                <p class="mt-1">{{ $job->status }}</p>
                            </div>
                            <div>
                                <h3 class="font-medium text-gray-700">Posted On</h3>
                                <p class="mt-1">{{ $job->created_at->format('F d, Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h2 class="text-xl font-semibold mb-4">Job Description</h2>
                        <div class="prose max-w-none">
                            {!! nl2br(e($job->description)) !!}
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex justify-end space-x-4">
                    <form action="{{ route('admin.jobs.update-status', $job) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <select name="status" onchange="this.form.submit()" class="text-sm border-gray-300 rounded-md">
                            <option value="Active" {{ $job->status === 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Closed" {{ $job->status === 'Closed' ? 'selected' : '' }}>Closed</option>
                        </select>
                    </form>
                    <form action="{{ route('admin.jobs.delete', $job) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600" onclick="return confirm('Are you sure you want to delete this job?')">Delete Job</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 