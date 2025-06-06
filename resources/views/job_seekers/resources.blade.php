<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Career Resources - CareerCON</title>
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
                    <h1 class="display-6 fw-bold mb-3">Career Resources</h1>
                    <p class="mb-0">Access tools and guides to boost your career journey.</p>
                </div>
                <div class="d-none d-md-block">
                    <i class="bi bi-book" style="font-size: 3rem; opacity: 0.8;"></i>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Resume Templates -->
            <div class="col-md-6 col-lg-3">
                <div class="dashboard-card p-4 bg-white">
                    <div class="card-icon">
                        <i class="bi bi-file-earmark-text"></i>
                    </div>
                    <h3 class="h5">Resume Templates</h3>
                    <ul class="list-unstyled text-muted mb-3">
                        <li class="mb-2"><a href="#" class="text-decoration-none text-muted hover-primary">Professional Resume Template</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-muted hover-primary">Entry-Level Resume Template</a></li>
                        <li><a href="#" class="text-decoration-none text-muted hover-primary">Internship Resume Template</a></li>
                    </ul>
                    <a href="#" class="btn btn-sm btn-outline-primary">View All Templates</a>
                </div>
            </div>

            <!-- Interview Tips -->
            <div class="col-md-6 col-lg-3">
                <div class="dashboard-card p-4 bg-white">
                    <div class="card-icon">
                        <i class="bi bi-chat-square-text"></i>
                    </div>
                    <h3 class="h5">Interview Tips</h3>
                    <ul class="list-unstyled text-muted mb-3">
                        <li class="mb-2"><a href="#" class="text-decoration-none text-muted hover-primary">Common Interview Questions</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-muted hover-primary">Interview Preparation Guide</a></li>
                        <li><a href="#" class="text-decoration-none text-muted hover-primary">Virtual Interview Tips</a></li>
                    </ul>
                    <a href="#" class="btn btn-sm btn-outline-primary">View All Tips</a>
                </div>
            </div>

            <!-- Career Development -->
            <div class="col-md-6 col-lg-3">
                <div class="dashboard-card p-4 bg-white">
                    <div class="card-icon">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>
                    <h3 class="h5">Career Development</h3>
                    <ul class="list-unstyled text-muted mb-3">
                        <li class="mb-2"><a href="#" class="text-decoration-none text-muted hover-primary">Career Planning Guide</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-muted hover-primary">Skill Development Resources</a></li>
                        <li><a href="#" class="text-decoration-none text-muted hover-primary">Industry Insights</a></li>
                    </ul>
                    <a href="#" class="btn btn-sm btn-outline-primary">View All Resources</a>
                </div>
            </div>

            <!-- Networking -->
            <div class="col-md-6 col-lg-3">
                <div class="dashboard-card p-4 bg-white">
                    <div class="card-icon">
                        <i class="bi bi-people"></i>
                    </div>
                    <h3 class="h5">Networking</h3>
                    <ul class="list-unstyled text-muted mb-3">
                        <li class="mb-2"><a href="#" class="text-decoration-none text-muted hover-primary">Professional Networking Tips</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-muted hover-primary">LinkedIn Profile Guide</a></li>
                        <li><a href="#" class="text-decoration-none text-muted hover-primary">Industry Events Calendar</a></li>
                    </ul>
                    <a href="#" class="btn btn-sm btn-outline-primary">View All Resources</a>
                </div>
            </div>
        </div>
    </main>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 