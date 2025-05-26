<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Applications - CareerCON</title>
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

        .table {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: var(--card-shadow);
        }

        .table thead th {
            background-color: var(--light-bg);
            border-bottom: none;
            font-weight: 600;
        }

        .table tbody tr:hover {
            background-color: rgba(67, 97, 238, 0.05);
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
                    <h1 class="display-6 fw-bold mb-3">Job Applications</h1>
                    <p class="mb-0">Review and manage applications for {{ $job->title }}</p>
                </div>
                <div class="d-none d-md-block">
                    <i class="bi bi-people" style="font-size: 3rem; opacity: 0.8;"></i>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h4 mb-0">Application List</h2>
            <a href="{{ route('employer.jobs.index') }}" class="btn btn-outline-primary">
                <i class="bi bi-arrow-left me-1"></i>Back to Jobs
            </a>
        </div>

        @if($applications->isEmpty())
            <div class="dashboard-card p-5 bg-white text-center">
                <i class="bi bi-people mb-3" style="font-size: 3rem; color: var(--primary-color);"></i>
                <h3 class="h5 mb-3">No Applications Yet</h3>
                <p class="text-muted mb-4">There are no applications for this job posting at the moment.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Applicant</th>
                            <th>Applied Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($applications as $application)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-person-circle me-2" style="font-size: 1.5rem;"></i>
                                        <div>
                                            <div class="fw-medium">{{ $application->user->full_name }}</div>
                                            <div class="text-muted small">{{ $application->user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $application->created_at->format('M d, Y') }}</td>
                                <td>
                                    <span class="status-badge status-{{ strtolower($application->status) }}">
                                        {{ $application->status }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('employer.applications.show', $application->id) }}" class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-eye me-1"></i>View
                                        </a>
                                        @if($application->status === 'Pending')
                                            <form action="{{ route('employer.applications.update', $application->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="Accepted">
                                                <button type="submit" class="btn btn-outline-success btn-sm">
                                                    <i class="bi bi-check-circle me-1"></i>Accept
                                                </button>
                                            </form>
                                            <form action="{{ route('employer.applications.update', $application->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="Rejected">
                                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                                    <i class="bi bi-x-circle me-1"></i>Reject
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $applications->links() }}
            </div>
        @endif
    </main>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 