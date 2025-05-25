<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Edit Job</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
</head>
<body class="bg-gray-100">

<div class="max-w-xl mx-auto py-6">
    <h1 class="text-2xl font-bold mb-4">Edit Job</h1>

    {{-- Show validation errors if any --}}
    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
            <ul class="list-disc ml-4">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('employer.jobs.update', $job->id) }}" method="POST" class="bg-white shadow p-6 rounded-lg">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="title" class="block font-medium">Job Title</label>
            <input type="text" name="title" id="title" class="w-full border-gray-300 rounded p-2" value="{{ old('title', $job->title) }}" />
        </div>

        <div class="mb-4">
            <label for="location" class="block font-medium">Location</label>
            <input type="text" name="location" id="location" class="w-full border-gray-300 rounded p-2" value="{{ old('location', $job->location) }}" />
        </div>

        <div class="mb-4">
            <label for="description" class="block font-medium">Description</label>
            <textarea name="description" id="description" rows="5" class="w-full border-gray-300 rounded p-2">{{ old('description', $job->description) }}</textarea>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update Job</button>
        <a href="{{ route('employer.jobs.index') }}" class="ml-4 text-gray-600">Cancel</a>
    </form>
</div>

</body>
</html>
