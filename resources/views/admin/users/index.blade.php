<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>User Management - CareerCON</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                    <h1 class="text-2xl font-bold">User Management</h1>
                    <a href="{{ route('dashboard') }}" class="text-blue-500 hover:text-blue-700">← Back to Dashboard</a>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Additional Info</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($users as $user)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $user->full_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($user->user_type) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($user->user_type === 'student')
                                        ID: {{ $user->student_id }} | Grad: {{ $user->graduation_year }}
                                    @elseif($user->user_type === 'employer')
                                        Company: {{ $user->company_name }}
                                    @elseif($user->user_type === 'professional')
                                        Job: {{ $user->current_job }}
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <button 
                                        class="edit-user-btn text-blue-500 hover:text-blue-700 mr-2"
                                        data-id="{{ $user->id }}"
                                        data-first-name="{{ $user->first_name }}"
                                        data-last-name="{{ $user->last_name }}"
                                        data-email="{{ $user->email }}"
                                        data-type="{{ $user->user_type }}"
                                        data-student-id="{{ $user->student_id }}"
                                        data-graduation-year="{{ $user->graduation_year }}"
                                        data-company-name="{{ $user->company_name }}"
                                        data-current-job="{{ $user->current_job }}"
                                    >
                                        Edit
                                    </button>
                                    <button 
                                        class="delete-user-btn text-red-500 hover:text-red-700"
                                        data-id="{{ $user->id }}"
                                    >
                                        Delete
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Edit User</h3>
                <form id="editUserForm" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="userId" name="user_id">
                    
                    <div class="mb-4">
                        <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                        <input type="text" id="first_name" name="first_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div class="mb-4">
                        <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                        <input type="text" id="last_name" name="last_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="email" name="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div class="mb-4">
                        <label for="user_type" class="block text-sm font-medium text-gray-700">User Type</label>
                        <select id="user_type" name="user_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" onchange="toggleTypeFields()">
                            <option value="student">Student</option>
                            <option value="professional">Professional</option>
                            <option value="employer">Employer</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>

                    <!-- Student Fields -->
                    <div id="studentFields" class="hidden">
                        <div class="mb-4">
                            <label for="student_id" class="block text-sm font-medium text-gray-700">Student ID</label>
                            <input type="text" id="student_id" name="student_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div class="mb-4">
                            <label for="graduation_year" class="block text-sm font-medium text-gray-700">Graduation Year</label>
                            <input type="number" id="graduation_year" name="graduation_year" min="2000" max="2100" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>

                    <!-- Employer Fields -->
                    <div id="employerFields" class="hidden">
                        <div class="mb-4">
                            <label for="company_name" class="block text-sm font-medium text-gray-700">Company Name</label>
                            <input type="text" id="company_name" name="company_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>

                    <!-- Professional Fields -->
                    <div id="professionalFields" class="hidden">
                        <div class="mb-4">
                            <label for="current_job" class="block text-sm font-medium text-gray-700">Current Job</label>
                            <input type="text" id="current_job" name="current_job" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>

                    <div class="mt-4 flex justify-end space-x-3">
                        <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleTypeFields() {
            const userType = document.getElementById('user_type').value;
            
            // Hide all type-specific fields
            document.getElementById('studentFields').classList.add('hidden');
            document.getElementById('employerFields').classList.add('hidden');
            document.getElementById('professionalFields').classList.add('hidden');
            
            // Show relevant fields based on user type
            if (userType === 'student') {
                document.getElementById('studentFields').classList.remove('hidden');
            } else if (userType === 'employer') {
                document.getElementById('employerFields').classList.remove('hidden');
            } else if (userType === 'professional') {
                document.getElementById('professionalFields').classList.remove('hidden');
            }
        }

        function closeModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Add click event listeners to all edit buttons
            document.querySelectorAll('.edit-user-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.dataset.id;
                    const firstName = this.dataset.firstName;
                    const lastName = this.dataset.lastName;
                    const email = this.dataset.email;
                    const type = this.dataset.type;
                    const studentId = this.dataset.studentId;
                    const graduationYear = this.dataset.graduationYear;
                    const companyName = this.dataset.companyName;
                    const currentJob = this.dataset.currentJob;

                    document.getElementById('userId').value = id;
                    document.getElementById('first_name').value = firstName;
                    document.getElementById('last_name').value = lastName;
                    document.getElementById('email').value = email;
                    document.getElementById('user_type').value = type;
                    document.getElementById('student_id').value = studentId;
                    document.getElementById('graduation_year').value = graduationYear;
                    document.getElementById('company_name').value = companyName;
                    document.getElementById('current_job').value = currentJob;
                    document.getElementById('editUserForm').action = `/admin/users/${id}`;
                    
                    toggleTypeFields();
                    document.getElementById('editModal').classList.remove('hidden');
                });
            });

            // Handle form submission
            document.getElementById('editUserForm').addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                const id = document.getElementById('userId').value;
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                
                fetch(`/admin/users/${id}`, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(Object.fromEntries(formData))
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Error updating user: ' + (data.message || 'Unknown error'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error updating user: ' + error.message);
                });
            });

            // Add click event listeners to all delete buttons
            document.querySelectorAll('.delete-user-btn').forEach(button => {
                button.addEventListener('click', function() {
                    if (confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
                        const id = this.dataset.id;
                        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                        
                        fetch(`/admin/users/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Remove the row from the table
                                this.closest('tr').remove();
                                alert('User deleted successfully');
                            } else {
                                alert('Error deleting user: ' + (data.message || 'Unknown error'));
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Error deleting user: ' + error.message);
                        });
                    }
                });
            });
        });
    </script>
</body>
</html> 