<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $job->title }} - CareerCON</title>
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
        
        .card-icon {
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
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
                    <h1 class="display-6 fw-bold mb-3">{{ $job->title }}</h1>
                    <p class="mb-0">{{ $job->employer->company_name }}</p>
                </div>
                <div class="d-none d-md-block">
                    <i class="bi bi-briefcase" style="font-size: 3rem; opacity: 0.8;"></i>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-8">
                <div class="dashboard-card p-4 bg-white">
                    <h3 class="h5 mb-4">Job Description</h3>
                    <div class="mb-4">
                        {{ $job->description }}
                    </div>

                    <h3 class="h5 mb-4">Requirements</h3>
                    <div class="mb-4">
                        {{ $job->requirements }}
                    </div>

                    <h3 class="h5 mb-4">Skills Required</h3>
                    <div class="mb-4">
                        @foreach($job->skills as $skill)
                            <span class="badge bg-primary me-2">{{ $skill->name }}</span>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="dashboard-card p-4 bg-white">
                    <h3 class="h5 mb-4">Job Details</h3>
                    <div class="mb-3">
                        <label class="form-label text-muted">Location</label>
                        <p class="mb-0">
                            <i class="bi bi-geo-alt me-2"></i>{{ $job->location }}
                        </p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted">Salary</label>
                        <p class="mb-0">
                            <i class="bi bi-currency-dollar me-2"></i>{{ $job->salary }}
                        </p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted">Job Type</label>
                        <p class="mb-0">
                            <i class="bi bi-briefcase me-2"></i>{{ ucfirst($job->type) }}
                        </p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted">Posted On</label>
                        <p class="mb-0">
                            <i class="bi bi-calendar me-2"></i>{{ $job->created_at->format('M d, Y') }}
                        </p>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        @if(!$hasApplied)
                            <form action="{{ route('job_seeker.jobs.apply', $job) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-send me-2"></i>Apply Now
                                </button>
                            </form>
                        @else
                            <button class="btn btn-secondary w-100" disabled>
                                <i class="bi bi-check-circle me-2"></i>Already Applied
                            </button>
                        @endif

                        @if(!$isSaved)
                            <form action="{{ route('job_seeker.jobs.save', $job) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline-primary w-100">
                                    <i class="bi bi-bookmark me-2"></i>Save Job
                                </button>
                            </form>
                        @else
                            <form action="{{ route('job_seeker.jobs.unsave', $job) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger w-100">
                                    <i class="bi bi-bookmark-x me-2"></i>Remove from Saved
                                </button>
                            </form>
                        @endif

                        <a href="{{ route('job_seeker.opportunities') }}" class="btn btn-outline-secondary w-100">
                            <i class="bi bi-arrow-left me-2"></i>Back to Opportunities
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 