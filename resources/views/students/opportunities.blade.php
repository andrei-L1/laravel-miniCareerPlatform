@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Available Opportunities</h1>
            <a href="{{ route('dashboard') }}" class="text-blue-500 hover:text-blue-700">← Back to Dashboard</a>
        </div>

        <div class="bg-white shadow rounded-lg p-6">
            @forelse($jobs as $job)
                <div class="border-b border-gray-200 py-4">
                    <h2 class="text-xl font-semibold mb-2">{{ $job->title }}</h2>
                    <p class="text-gray-600 mb-2">{{ $job->employer->company_name }}</p>
                    <p class="text-gray-600 mb-2">{{ $job->location }}</p>
                    <p class="text-gray-600 mb-2">Salary: {{ $job->salary }}</p>
                    <div class="mt-4">
                        <a href="#" class="text-blue-500 hover:text-blue-700">View Details →</a>
                    </div>
                </div>
            @empty
                <p class="text-gray-600">No job opportunities available at the moment.</p>
            @endforelse

            <div class="mt-4">
                {{ $jobs->links() }}
            </div>
        </div>
    </div>
</div>
@endsection 