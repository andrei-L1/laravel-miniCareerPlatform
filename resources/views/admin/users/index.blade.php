<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>User Management - CareerCON</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --accent-color: #4cc9f0;
            --light-bg: #f8f9fa;
            --card-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            --card-hover-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }
        
        body {
            background-color: var(--light-bg);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .navbar-brand {
            font-weight: 700;
            color: var(--primary-color);
            font-size: 1.5rem;
        }
        
        .dashboard-card {
            border: none;
            border-radius: 10px;
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
            height: 100%;
        }
        
        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--card-hover-shadow);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            color: white;
        }

        .welcome-banner {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border-radius: 10px;
            padding: 2rem;
            margin-bottom: 2rem;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('dashboard') }}">CareerCON</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1"></i> {{ auth()->user()->full_name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profile</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('auth.destroy') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container py-4">
        <div class="welcome-banner">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="display-6 fw-bold mb-3">User Management</h1>
                    <p class="mb-0">Manage and monitor all platform users</p>
                </div>
                <div class="d-none d-md-block">
                    <i class="bi bi-people-fill" style="font-size: 3rem; opacity: 0.8;"></i>
                </div>
            </div>
        </div>

        <div class="dashboard-card p-4 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h5 mb-0">All Users</h2>
                <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-arrow-left me-1"></i>Back to Dashboard
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Type</th>
                            <th>Additional Info</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->full_name }}</td>
                            <td>{{ $user->email }}</td>
                            <td><span class="badge bg-primary">{{ ucfirst($user->user_type) }}</span></td>
                            <td>
                                @if($user->user_type === 'student')
                                    <small class="text-muted">ID: {{ $user->student_id }} | Grad: {{ $user->graduation_year }}</small>
                                @elseif($user->user_type === 'employer')
                                    <small class="text-muted">Company: {{ $user->company_name }}</small>
                                @elseif($user->user_type === 'professional')
                                    <small class="text-muted">Job: {{ $user->current_job }}</small>
                                @endif
                            </td>
                            <td>
                                <button 
                                    class="btn btn-sm btn-outline-primary edit-user-btn me-2"
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
                                    <i class="bi bi-pencil me-1"></i>Edit
                                </button>
                                <button 
                                    class="btn btn-sm btn-outline-danger delete-user-btn"
                                    data-id="{{ $user->id }}"
                                >
                                    <i class="bi bi-trash me-1"></i>Delete
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
    </main>

    <!-- Edit User Modal -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editUserForm" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="userId" name="user_id">
                        
                        <div class="mb-3">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name">
                        </div>

                        <div class="mb-3">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name">
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>

                        <div class="mb-3">
                            <label for="user_type" class="form-label">User Type</label>
                            <select class="form-select" id="user_type" name="user_type" onchange="toggleTypeFields()">
                                <option value="student">Student</option>
                                <option value="professional">Professional</option>
                                <option value="employer">Employer</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>

                        <!-- Student Fields -->
                        <div id="studentFields" class="d-none">
                            <div class="mb-3">
                                <label for="student_id" class="form-label">Student ID</label>
                                <input type="text" class="form-control" id="student_id" name="student_id">
                            </div>
                            <div class="mb-3">
                                <label for="graduation_year" class="form-label">Graduation Year</label>
                                <input type="number" class="form-control" id="graduation_year" name="graduation_year" min="2000" max="2100">
                            </div>
                        </div>

                        <!-- Employer Fields -->
                        <div id="employerFields" class="d-none">
                            <div class="mb-3">
                                <label for="company_name" class="form-label">Company Name</label>
                                <input type="text" class="form-control" id="company_name" name="company_name">
                            </div>
                        </div>

                        <!-- Professional Fields -->
                        <div id="professionalFields" class="d-none">
                            <div class="mb-3">
                                <label for="current_job" class="form-label">Current Job</label>
                                <input type="text" class="form-control" id="current_job" name="current_job">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="editUserForm" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleTypeFields() {
            const userType = document.getElementById('user_type').value;
            
            // Hide all type-specific fields
            document.getElementById('studentFields').classList.add('d-none');
            document.getElementById('employerFields').classList.add('d-none');
            document.getElementById('professionalFields').classList.add('d-none');
            
            // Show relevant fields based on user type
            if (userType === 'student') {
                document.getElementById('studentFields').classList.remove('d-none');
            } else if (userType === 'employer') {
                document.getElementById('employerFields').classList.remove('d-none');
            } else if (userType === 'professional') {
                document.getElementById('professionalFields').classList.remove('d-none');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const editModal = new bootstrap.Modal(document.getElementById('editModal'));

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
                    editModal.show();
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