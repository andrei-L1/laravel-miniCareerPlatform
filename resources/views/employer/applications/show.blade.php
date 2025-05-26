<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Details - CareerCON</title>
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
        
        .status-badge {
            font-size: 0.875rem;
            padding: 0.35em 0.65em;
            border-radius: 50rem;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-accepted {
            background-color: #d1e7dd;
            color: #0f5132;
        }

        .status-rejected {
            background-color: #f8d7da;
            color: #842029;
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
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="welcome-banner">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="display-6 fw-bold mb-3">Application Details</h1>
                    <p class="mb-0">Review application for {{ $application->job->title }}</p>
                </div>
                <div class="d-none d-md-block">
                    <i class="bi bi-file-earmark-text" style="font-size: 3rem; opacity: 0.8;"></i>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h4 mb-0">Applicant Information</h2>
            <a href="{{ route('employer.jobs.applications', $application->job) }}" class="btn btn-outline-primary">
                <i class="bi bi-arrow-left me-1"></i>Back to Applications
            </a>
        </div>

        <div class="row g-4">
            <div class="col-md-8">
                <div class="dashboard-card p-4 bg-white">
                    <h3 class="h5 mb-4">Applicant Details</h3>
                    <div class="mb-4">
                        <h4 class="h6 text-muted mb-2">Full Name</h4>
                        <p class="mb-0">{{ $application->user->full_name }}</p>
                    </div>
                    <div class="mb-4">
                        <h4 class="h6 text-muted mb-2">Email</h4>
                        <p class="mb-0">{{ $application->user->email }}</p>
                    </div>
                    <div class="mb-4">
                        <h4 class="h6 text-muted mb-2">Applied Date</h4>
                        <p class="mb-0">{{ $application->created_at->format('F d, Y') }}</p>
                    </div>
                    <div class="mb-4">
                        <h4 class="h6 text-muted mb-2">Status</h4>
                        <span class="status-badge status-{{ strtolower($application->status) }}">
                            {{ $application->status }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="dashboard-card p-4 bg-white">
                    <h3 class="h5 mb-4">Actions</h3>
                    @if($application->status === 'Pending')
                        <form action="{{ route('employer.applications.update', $application) }}" method="POST" class="mb-3">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="Accepted">
                            <button type="submit" class="btn btn-success w-100">
                                <i class="bi bi-check-circle me-1"></i>Accept Application
                            </button>
                        </form>
                        <form action="{{ route('employer.applications.update', $application) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="Rejected">
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="bi bi-x-circle me-1"></i>Reject Application
                            </button>
                        </form>
                    @else
                        <p class="text-muted mb-0">This application has already been {{ strtolower($application->status) }}.</p>
                    @endif
                </div>
            </div>
        </div>
    </main>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 