<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candidate Search - CareerCON</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
        }
        
        .welcome-banner {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border-radius: 10px;
            padding: 2rem;
            margin-bottom: 2rem;
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

        .candidate-card {
            border: none;
            border-radius: 10px;
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
        }

        .candidate-card:hover {
            box-shadow: var(--card-hover-shadow);
            transform: translateY(-2px);
        }

        .skill-badge {
            background-color: #e9ecef;
            color: #495057;
            padding: 0.35em 0.65em;
            border-radius: 50rem;
            font-size: 0.875rem;
            margin: 0.25rem;
            display: inline-block;
        }

        .select2-container--default .select2-selection--multiple {
            border-color: #dee2e6;
            border-radius: 0.375rem;
        }

        .select2-container--default.select2-container--focus .select2-selection--multiple {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.25);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">CareerCON</a>
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
                    <h1 class="display-6 fw-bold mb-3">Candidate Search</h1>
                    <p class="mb-0">Find qualified candidates for your job openings.</p>
                </div>
                <div class="d-none d-md-block">
                    <i class="bi bi-search" style="font-size: 3rem; opacity: 0.8;"></i>
                </div>
            </div>
        </div>

        <div class="mb-4">
            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i>Back to Dashboard
            </a>
        </div>

        <div class="row">
            <!-- Search Filters -->
            <div class="col-md-4 mb-4">
                <div class="dashboard-card p-4 bg-white">
                    <h3 class="h5 mb-4">Search Filters</h3>
                    <form action="{{ route('employer.candidates.search') }}" method="GET">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ request('name') }}" placeholder="Search by name...">
                        </div>

                        <div class="mb-3">
                            <label for="skills" class="form-label">Skills</label>
                            <select class="form-select" id="skills" name="skills[]" multiple>
                                @foreach($skills as $skill)
                                    <option value="{{ $skill->name }}" {{ in_array($skill->name, request('skills', [])) ? 'selected' : '' }}>
                                        {{ $skill->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="user_type" class="form-label">Candidate Type</label>
                            <select class="form-select" id="user_type" name="user_type">
                                <option value="">All Types</option>
                                <option value="student" {{ request('user_type') === 'student' ? 'selected' : '' }}>Student</option>
                                <option value="professional" {{ request('user_type') === 'professional' ? 'selected' : '' }}>Professional</option>
                            </select>
                        </div>

                        <div class="mb-3" id="graduation_year_group" style="display: none;">
                            <label for="graduation_year" class="form-label">Graduation Year</label>
                            <input type="number" class="form-control" id="graduation_year" name="graduation_year" value="{{ request('graduation_year') }}" min="2000" max="{{ date('Y') + 4 }}">
                        </div>

                        <div class="mb-3" id="current_job_group" style="display: none;">
                            <label for="current_job" class="form-label">Current Job</label>
                            <input type="text" class="form-control" id="current_job" name="current_job" value="{{ request('current_job') }}" placeholder="Search by current job...">
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-search me-1"></i>Search
                            </button>
                            <a href="{{ route('employer.candidates.search') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle me-1"></i>Clear Filters
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Search Results -->
            <div class="col-md-8">
                @if($candidates->isEmpty())
                    <div class="dashboard-card p-5 bg-white text-center">
                        <i class="bi bi-search mb-3" style="font-size: 3rem; color: var(--primary-color);"></i>
                        <h3 class="h5 mb-3">No Candidates Found</h3>
                        <p class="text-muted mb-4">Try adjusting your search filters to find more candidates.</p>
                    </div>
                @else
                    <div class="row g-4">
                        @foreach($candidates as $candidate)
                            <div class="col-12">
                                <div class="candidate-card p-4 bg-white">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h3 class="h5 mb-2">{{ $candidate->full_name }}</h3>
                                            <p class="text-muted mb-2">
                                                <i class="bi bi-envelope me-1"></i>{{ $candidate->email }}
                                            </p>
                                            <p class="text-muted mb-2">
                                                <i class="bi bi-person-badge me-1"></i>
                                                {{ ucfirst($candidate->user_type) }}
                                                @if($candidate->user_type === 'student')
                                                    (Graduation: {{ $candidate->graduation_year }})
                                                @else
                                                    ({{ $candidate->current_job }})
                                                @endif
                                            </p>
                                            <div class="mb-3">
                                                @foreach($candidate->skills as $skill)
                                                    <span class="skill-badge">{{ $skill->name }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div>
                                            <a href="#" class="btn btn-outline-primary">
                                                <i class="bi bi-eye me-1"></i>View Profile
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4">
                        {{ $candidates->links() }}
                    </div>
                @endif
            </div>
        </div>
    </main>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize Select2 for skills
            $('#skills').select2({
                placeholder: 'Select skills...',
                allowClear: true
            });

            // Show/hide graduation year and current job fields based on user type
            function toggleFields() {
                const userType = $('#user_type').val();
                if (userType === 'student') {
                    $('#graduation_year_group').show();
                    $('#current_job_group').hide();
                } else if (userType === 'professional') {
                    $('#graduation_year_group').hide();
                    $('#current_job_group').show();
                } else {
                    $('#graduation_year_group').hide();
                    $('#current_job_group').hide();
                }
            }

            // Initial toggle
            toggleFields();

            // Toggle on change
            $('#user_type').change(toggleFields);
        });
    </script>
</body>
</html> 