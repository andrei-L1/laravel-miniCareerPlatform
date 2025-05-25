@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Saved Jobs</h1>
            <a href="{{ route('dashboard') }}" class="text-blue-500 hover:text-blue-700">← Back to Dashboard</a>
        </div>

        @if($savedJobs->isEmpty())
            <div class="bg-white shadow rounded-lg p-6 text-center">
                <p class="text-gray-500">You haven't saved any jobs yet.</p>
                <a href="{{ route('job_seeker.opportunities') }}" class="mt-4 inline-block text-blue-500 hover:text-blue-700">Browse Available Opportunities</a>
            </div>
        @else
            <div class="grid grid-cols-1 gap-6">
                @foreach($savedJobs as $savedJob)
                    <div class="bg-white shadow rounded-lg p-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <h2 class="text-xl font-semibold text-gray-900">{{ $savedJob->job->title }}</h2>
                                <p class="text-gray-600">{{ $savedJob->job->employer->company_name }}</p>
                                <div class="mt-2 flex items-center text-sm text-gray-500">
                                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    {{ $savedJob->job->location }}
                                </div>
                                <div class="mt-1 flex items-center text-sm text-gray-500">
                                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $savedJob->job->salary }}
                                </div>
                            </div>
                            <div class="flex space-x-3">
                                <a href="{{ route('jobs.show', $savedJob->job) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                    View Details
                                </a>
                                <form action="{{ route('job_seekers.saved_jobs.destroy', $savedJob) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                        Remove
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $savedJobs->links() }}
            </div>
        @endif
    </div>
</div>
@endsection 