<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Details - CareerCON</title>
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
                    <h1 class="display-6 fw-bold mb-3">Job Details</h1>
                    <p class="mb-0">View and manage job posting details</p>
                </div>
                <div class="d-none d-md-block">
                    <i class="bi bi-file-earmark-text" style="font-size: 3rem; opacity: 0.8;"></i>
                </div>
            </div>
        </div>

        <div class="dashboard-card p-4 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h5 mb-0">{{ $job->title }}</h2>
                <div>
                    <a href="{{ route('admin.jobs') }}" class="btn btn-sm btn-outline-primary me-2">
                        <i class="bi bi-arrow-left me-1"></i>Back to Jobs
                    </a>
                    <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-house me-1"></i>Dashboard
                    </a>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-md-6">
                    <div class="dashboard-card p-4 bg-white">
                        <h3 class="h5 mb-4">Job Information</h3>
                        <div class="mb-3">
                            <label class="form-label text-muted">Title</label>
                            <p class="mb-0">{{ $job->title }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted">Company</label>
                            <p class="mb-0">{{ $job->employer->company_name }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted">Location</label>
                            <p class="mb-0">{{ $job->location }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted">Salary</label>
                            <p class="mb-0">{{ $job->salary }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted">Status</label>
                            <p class="mb-0">
                                <span class="badge bg-{{ $job->status === 'Active' ? 'success' : 'secondary' }}">
                                    {{ $job->status }}
                                </span>
                            </p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted">Posted On</label>
                            <p class="mb-0">{{ $job->created_at ? $job->created_at->format('F d, Y') : 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="dashboard-card p-4 bg-white">
                        <h3 class="h5 mb-4">Job Description</h3>
                        <div class="prose">
                            {!! nl2br(e($job->description)) !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4 d-flex justify-content-end gap-2">
                <form action="{{ route('admin.jobs.update-status', $job) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PATCH')
                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="Active" {{ $job->status === 'Active' ? 'selected' : '' }}>Active</option>
                        <option value="Closed" {{ $job->status === 'Closed' ? 'selected' : '' }}>Closed</option>
                    </select>
                </form>
                <form action="{{ route('admin.jobs.delete', $job) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this job?')">
                        <i class="bi bi-trash me-1"></i>Delete Job
                    </button>
                </form>
            </div>
        </div>
    </main>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 