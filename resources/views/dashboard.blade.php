<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - CareerCON</title>
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
        
        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-color);
        }
        
        .welcome-banner {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border-radius: 10px;
            padding: 2rem;
            margin-bottom: 2rem;
        }
        
        .nav-pills .nav-link.active {
            background-color: var(--primary-color);
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
                    <h1 class="display-6 fw-bold mb-3">Welcome back, {{ auth()->user()->full_name }}!</h1>
                    <p class="mb-0">Here's what's happening with your account today.</p>
                </div>
                <div class="d-none d-md-block">
                    <i class="bi bi-person-badge" style="font-size: 3rem; opacity: 0.8;"></i>
                </div>
            </div>
        </div>

        @if(auth()->user()->user_type === 'admin')
        <!-- Admin Dashboard -->
        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="dashboard-card p-4 bg-white">
                    <div class="card-icon">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <h3 class="h5">User Management</h3>
                    <p class="text-muted mb-3">Manage all platform users and permissions</p>
                    <a href="{{ route('admin.users') }}" class="btn btn-sm btn-outline-primary">Manage Users</a>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-3">
                <div class="dashboard-card p-4 bg-white">
                    <div class="card-icon">
                        <i class="bi bi-graph-up"></i>
                    </div>
                    <h3 class="h5">Platform Stats</h3>
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="small text-muted mb-1">Total Users</p>
                            <p class="stat-number mb-0">{{ $totalUsers ?? 0 }}</p>
                        </div>
                        <div>
                            <p class="small text-muted mb-1">Active Jobs</p>
                            <p class="stat-number mb-0">{{ $activeJobs ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-3">
                <div class="dashboard-card p-4 bg-white">
                    <div class="card-icon">
                        <i class="bi bi-briefcase-fill"></i>
                    </div>
                    <h3 class="h5">Job Postings</h3>
                    <p class="text-muted mb-3">Review and manage job listings</p>
                    <a href="{{ route('admin.jobs') }}" class="btn btn-sm btn-outline-primary">Manage Jobs</a>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-3">
                <div class="dashboard-card p-4 bg-white">
                    <div class="card-icon">
                        <i class="bi bi-gear-fill"></i>
                    </div>
                    <h3 class="h5">System Settings</h3>
                    <p class="text-muted mb-3">Configure platform settings</p>
                    <a href="{{ route('admin.settings') }}" class="btn btn-sm btn-outline-primary">Settings</a>
                </div>
            </div>
            
            <div class="col-12">
                <div class="dashboard-card p-4 bg-white">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="h5 mb-0">Recent Activity</h3>
                        <a href="#" class="btn btn-sm btn-outline-secondary">View All</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Event</th>
                                    <th>Description</th>
                                    <th>Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><span class="badge bg-primary">New User</span></td>
                                    <td>John Doe registered</td>
                                    <td>2 mins ago</td>
                                </tr>
                                <tr>
                                    <td><span class="badge bg-success">New Job</span></td>
                                    <td>Developer position at ABC Corp</td>
                                    <td>15 mins ago</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        @elseif(auth()->user()->isJobSeeker())
        <!-- Job Seeker Dashboard -->
        <div class="row g-4">
            <div class="col-md-6">
                <div class="dashboard-card p-4 bg-white">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="card-icon">
                                <i class="bi bi-person-circle"></i>
                            </div>
                            <h3 class="h5">My Profile</h3>
                            @if(auth()->user()->user_type === 'student')
                                <p class="mb-1"><strong>Student ID:</strong> {{ auth()->user()->student_id }}</p>
                                <p class="mb-3"><strong>Graduation Year:</strong> {{ auth()->user()->graduation_year }}</p>
                            @else
                                <p class="mb-3"><strong>Current Job:</strong> {{ auth()->user()->current_job }}</p>
                            @endif
                            <a href="#" class="btn btn-sm btn-outline-primary">Edit Profile</a>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                Quick Actions
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#">Update Resume</a></li>
                                <li><a class="dropdown-item" href="#">Edit Profile</a></li>
                                <li><a class="dropdown-item" href="#">Privacy Settings</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="dashboard-card p-4 bg-white">
                    <div class="card-icon">
                        <i class="bi bi-briefcase"></i>
                    </div>
                    <h3 class="h5">Job Opportunities</h3>
                    <p class="text-muted mb-3">Browse and apply for jobs matching your profile</p>
                    <a href="{{ route('job_seeker.opportunities') }}" class="btn btn-sm btn-primary">Explore Jobs</a>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="dashboard-card p-4 bg-white">
                    <div class="card-icon">
                        <i class="bi bi-file-earmark-text"></i>
                    </div>
                    <h3 class="h5">Career Resources</h3>
                    <p class="text-muted mb-3">Resume templates, interview tips and more</p>
                    <a href="{{ route('job_seeker.resources') }}" class="btn btn-sm btn-outline-primary">View Resources</a>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="dashboard-card p-4 bg-white">
                    <div class="card-icon">
                        <i class="bi bi-bookmark-star"></i>
                    </div>
                    <h3 class="h5">Saved Jobs</h3>
                    <p class="text-muted mb-3">Your bookmarked job listings</p>
                    <a href="{{ route('job_seeker.saved_jobs') }}" class="btn btn-sm btn-outline-primary">View Saved Jobs</a>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="dashboard-card p-4 bg-white">
                    <div class="card-icon">
                        <i class="bi bi-envelope-paper"></i>
                    </div>
                    <h3 class="h5">Applications</h3>
                    <p class="text-muted mb-3">Track your job applications</p>
                    <a href="{{ route('job_seeker.applications') }}" class="btn btn-sm btn-outline-primary">View Applications</a>
                </div>
            </div>
        </div>
        
        @elseif(auth()->user()->user_type === 'employer')
        <!-- Employer Dashboard -->
        <div class="row g-4">
            <div class="col-md-12">
                <div class="dashboard-card p-4 bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="h5">Company Profile</h3>
                            <p class="mb-0"><strong>{{ auth()->user()->company_name }}</strong></p>
                        </div>
                        <div>
                            <a href="#" class="btn btn-sm btn-outline-primary">Edit Profile</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="dashboard-card p-4 bg-white">
                    <div class="card-icon">
                        <i class="bi bi-file-earmark-post"></i>
                    </div>
                    <h3 class="h5">Job Postings</h3>
                    <p class="text-muted mb-3">Manage your job listings</p>
                    <a href="{{ route('employer.jobs.index') }}" class="btn btn-sm btn-primary">Manage Jobs</a>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="dashboard-card p-4 bg-white">
                    <div class="card-icon">
                        <i class="bi bi-search"></i>
                    </div>
                    <h3 class="h5">Candidate Search</h3>
                    <p class="text-muted mb-3">Find qualified candidates</p>
                    <a href="{{ route('employer.candidates.search') }}" class="btn btn-sm btn-outline-primary">Search Now</a>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="dashboard-card p-4 bg-white">
                    <div class="card-icon">
                        <i class="bi bi-bar-chart"></i>
                    </div>
                    <h3 class="h5">Analytics</h3>
                    <p class="text-muted mb-3">View job posting performance</p>
                    <a href="#" class="btn btn-sm btn-outline-primary">View Analytics</a>
                </div>
            </div>
            
            <div class="col-12">
                <div class="dashboard-card p-4 bg-white">
                    <h3 class="h5 mb-3">Recent Applications</h3>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Position</th>
                                    <th>Applicant</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Frontend Developer</td>
                                    <td>John Smith</td>
                                    <td><span class="badge bg-warning text-dark">Pending</span></td>
                                    <td>Today</td>
                                    <td><a href="#" class="btn btn-sm btn-outline-secondary">View</a></td>
                                </tr>
                                <tr>
                                    <td>UX Designer</td>
                                    <td>Sarah Johnson</td>
                                    <td><span class="badge bg-success">Approved</span></td>
                                    <td>2 days ago</td>
                                    <td><a href="#" class="btn btn-sm btn-outline-secondary">View</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        @else
        <!-- Default Dashboard for other user types -->
        <div class="row">
            <div class="col-12">
                <div class="dashboard-card p-4 bg-white text-center">
                    <div class="card-icon">
                        <i class="bi bi-person-check"></i>
                    </div>
                    <h3 class="h5">Welcome to CareerCON</h3>
                    <p class="text-muted">You are logged in as a {{ auth()->user()->user_type }} user.</p>
                    <p>Your account is being set up. Please contact support if you need assistance.</p>
                    <a href="#" class="btn btn-sm btn-outline-primary">Contact Support</a>
                </div>
            </div>
        </div>
        @endif
    </main>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>