<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - CareerCON</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script>
        function toggleFields() {
            let type = document.getElementById('user_type').value;
            document.getElementById('student_fields').style.display = (type === 'student') ? 'block' : 'none';
            document.getElementById('professional_fields').style.display = (type === 'professional') ? 'block' : 'none';
            document.getElementById('employer_fields').style.display = (type === 'employer') ? 'block' : 'none';
        }
    </script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-md w-96">
        <h2 class="text-2xl font-bold mb-6 text-center">Register</h2>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('auth.store') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">User Type</label>
                <select name="user_type" id="user_type" onchange="toggleFields()" required
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="">-- Select --</option>
                    <option value="student">Student</option>
                    <option value="professional">Professional</option>
                    <option value="employer">Employer</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">First Name</label>
                <input type="text" name="first_name" required
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    value="{{ old('first_name') }}">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Last Name</label>
                <input type="text" name="last_name" required
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    value="{{ old('last_name') }}">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input type="email" name="email" required
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    value="{{ old('email') }}">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                <input type="password" name="password" required
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <!-- Student-only fields -->
            <div id="student_fields" style="display:none;">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Student ID</label>
                    <input type="text" name="student_id"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        value="{{ old('student_id') }}">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Graduation Year</label>
                    <input type="number" name="graduation_year"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        value="{{ old('graduation_year') }}">
                </div>
            </div>

            <!-- Professional-only fields -->
            <div id="professional_fields" style="display:none;">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Current Job</label>
                    <input type="text" name="current_job"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        value="{{ old('current_job') }}">
                </div>
            </div>

            <!-- Employer-only fields -->
            <div id="employer_fields" style="display:none;">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Company Name</label>
                    <input type="text" name="company_name"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        value="{{ old('company_name') }}">
                </div>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" 
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full">
                    Register
                </button>
            </div>
        </form>

        <div class="mt-4 text-center">
            <p class="text-sm text-gray-600">Already have an account? 
                <a href="{{ route('auth.index') }}" class="text-blue-500 hover:text-blue-700">Login here</a>
            </p>
        </div>
    </div>
</body>
</html>
