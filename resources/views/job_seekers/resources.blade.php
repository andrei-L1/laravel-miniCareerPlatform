@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Career Resources</h1>
            <a href="{{ route('dashboard') }}" class="text-blue-500 hover:text-blue-700">← Back to Dashboard</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Resume Templates -->
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-xl font-semibold mb-4">Resume Templates</h2>
                <ul class="space-y-2">
                    <li><a href="#" class="text-blue-500 hover:text-blue-700">Professional Resume Template</a></li>
                    <li><a href="#" class="text-blue-500 hover:text-blue-700">Entry-Level Resume Template</a></li>
                    <li><a href="#" class="text-blue-500 hover:text-blue-700">Internship Resume Template</a></li>
                </ul>
            </div>

            <!-- Interview Tips -->
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-xl font-semibold mb-4">Interview Tips</h2>
                <ul class="space-y-2">
                    <li><a href="#" class="text-blue-500 hover:text-blue-700">Common Interview Questions</a></li>
                    <li><a href="#" class="text-blue-500 hover:text-blue-700">Interview Preparation Guide</a></li>
                    <li><a href="#" class="text-blue-500 hover:text-blue-700">Virtual Interview Tips</a></li>
                </ul>
            </div>

            <!-- Career Development -->
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-xl font-semibold mb-4">Career Development</h2>
                <ul class="space-y-2">
                    <li><a href="#" class="text-blue-500 hover:text-blue-700">Career Planning Guide</a></li>
                    <li><a href="#" class="text-blue-500 hover:text-blue-700">Skill Development Resources</a></li>
                    <li><a href="#" class="text-blue-500 hover:text-blue-700">Industry Insights</a></li>
                </ul>
            </div>

            <!-- Networking -->
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-xl font-semibold mb-4">Networking</h2>
                <ul class="space-y-2">
                    <li><a href="#" class="text-blue-500 hover:text-blue-700">Professional Networking Tips</a></li>
                    <li><a href="#" class="text-blue-500 hover:text-blue-700">LinkedIn Profile Guide</a></li>
                    <li><a href="#" class="text-blue-500 hover:text-blue-700">Industry Events Calendar</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection 