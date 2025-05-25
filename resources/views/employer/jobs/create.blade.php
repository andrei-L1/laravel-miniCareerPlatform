<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Add New Job</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
</head>
<body class="bg-gray-100">

<div class="max-w-xl mx-auto py-6">
    <h1 class="text-2xl font-bold mb-4">Add New Job</h1>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('employer.jobs.store') }}" method="POST" class="bg-white shadow p-6 rounded-lg">

        @csrf

        <div class="mb-4">
            <label for="title" class="block font-medium">Job Title</label>
            <input type="text" name="title" id="title" class="w-full border-gray-300 rounded p-2" value="{{ old('title') }}" />
        </div>

        <div class="mb-4">
            <label for="location" class="block font-medium">Location</label>
            <input type="text" name="location" id="location" class="w-full border-gray-300 rounded p-2" value="{{ old('location') }}" />
        </div>

        <div class="mb-4">
            <label for="type" class="block font-medium">Job Type</label>
            <select name="type" id="type" class="w-full border-gray-300 rounded p-2">
                <option value="full-time">Full Time</option>
                <option value="part-time">Part Time</option>
                <option value="contract">Contract</option>
                <option value="internship">Internship</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="salary" class="block font-medium">Salary</label>
            <input type="number" name="salary" id="salary" class="w-full border-gray-300 rounded p-2" value="{{ old('salary') }}" />
        </div>

        <div class="mb-4">
            <label for="description" class="block font-medium">Description</label>
            <textarea name="description" id="description" rows="5" class="w-full border-gray-300 rounded p-2">{{ old('description') }}</textarea>
        </div>

        <div class="mb-4">
            <label for="requirements" class="block font-medium">Requirements</label>
            <textarea name="requirements" id="requirements" rows="5" class="w-full border-gray-300 rounded p-2">{{ old('requirements') }}</textarea>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save Job</button>
        <a href="{{ route('employer.jobs.index') }}" class="ml-4 text-gray-600">Cancel</a>
    </form>
</div>

</body>
</html>
