<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Job Postings</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
</head>
<body class="bg-gray-100">

    <div class="max-w-7xl mx-auto py-6 px-4">
        <h1 class="text-2xl font-bold mb-4">Job Postings</h1>

        <a href="{{ route('employer.jobs.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">+ Add Job</a>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow rounded-lg p-4">
            @forelse($jobs as $job)
                <div class="mb-4 border-b pb-2">
                    <h2 class="text-xl font-semibold">{{ $job->title }}</h2>
                    <p class="text-gray-600">{{ $job->location }}</p>
                    <div class="mt-2">
                        <a href="{{ route('employer.jobs.edit', $job->id) }}" class="text-blue-500 hover:underline">Edit</a>
                        <form action="{{ route('employer.jobs.destroy', $job->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button 
                                type="submit" 
                                class="text-red-500 ml-2 hover:underline" 
                                onclick="return confirm('Are you sure you want to delete this job?')">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p>No job postings found.</p>
            @endforelse
        </div>

        <!-- Pagination links -->
        <div class="mt-6">
            {{ $jobs->links() }}
        </div>
    </div>

</body>
</html>
