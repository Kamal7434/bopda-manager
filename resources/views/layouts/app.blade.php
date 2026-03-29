<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Gestion Étudiants') | Bopda Manager</title>
    
    <!-- Google Fonts: Inter pour un look moderne -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        :root {
            --sidebar-width: 260px;
            --primary-color: #4361ee;
            --dark-bg: #1e1e2d;
            --light-bg: #f8f9fa;
        }

        body { 
            font-family: 'Inter', sans-serif;
            background-color: var(--light-bg);
            color: #3f4254;
        }

        /* Sidebar Modernisée */
        .sidebar { 
            width: var(--sidebar-width);
            min-height: 100vh; 
            background: var(--dark-bg);
            color: #a2a3b7;
            position: fixed;
            transition: all 0.3s;
            z-index: 1000;
        }

        .sidebar-header {
            padding: 2rem 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        .sidebar-brand {
            color: #fff;
            font-weight: 700;
            font-size: 1.55rem;
            letter-spacing: -0.5px;
        }

        .nav-link {
            color: #a2a3b7;
            padding: 0.8rem 1.5rem;
            display: flex;
            align-items: center;
            border-radius: 0.475rem;
            margin: 0.2rem 1rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .nav-link i {
            font-size: 1.2rem;
            margin-right: 15px;
        }

        .nav-link:hover {
            background: rgba(255,255,255,0.05);
            color: #fff;
        }

        .nav-link.active {
            background: var(--primary-color);
            color: #fff !important;
        }

        /* Contenu Principal */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width));
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .content { padding: 30px; flex-grow: 1; }

        /* Navbar supérieure */
        .top-navbar {
            background: #fff;
            padding: 1rem 2rem;
            border-bottom: 1px solid #ebedef;
        }

        /* Amélioration des cartes */
        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border-radius: 0.75rem;
        }

        /* Bouton déconnexion en bas */
        .logout-container {
            position: absolute;
            bottom: 20px;
            width: 100%;
            padding: 0 1rem;
        }

        .btn-logout {
            background: rgba(241, 65, 108, 0.1);
            color: #f1416c;
            border: none;
            width: 100%;
            padding: 0.8rem;
            border-radius: 0.475rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .btn-logout:hover {
            background: #f1416c;
            color: #fff;
        }

        @media (max-width: 992px) {
            .sidebar { margin-left: calc(-1 * var(--sidebar-width)); }
            .main-wrapper { margin-left: 0; width: 100%; }
            .sidebar.active { margin-left: 0; }
        }
    </style>
</head>
<body>

<div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-brand d-flex align-items-center">
                <span>Bopda Manager</span>
            </div>
        </div>

        <nav class="mt-4">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill"></i> Dashboard
            </a>
            <a href="{{ route('students.index') }}" class="nav-link {{ request()->routeIs('students.*') ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i> Étudiants
            </a>
            <a href="{{ route('programs.index') }}" class="nav-link {{ request()->routeIs('programs.*') ? 'active' : '' }}">
                <i class="bi bi-journal-bookmark-fill"></i> Filières
            </a>
            <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                <i class="bi bi-person-badge-fill"></i> Admins
            </a>
        </nav>

        <div class="logout-container">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn-logout shadow-none">
                    <i class="bi bi-box-arrow-right me-2"></i> Déconnexion
                </button>
            </form>
        </div>
    </div>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <!-- Top Navbar -->
        <header class="top-navbar d-flex justify-content-between align-items-center shadow-none">
            <button class="btn d-lg-none" id="sidebarToggle">
                <i class="bi bi-list fs-3"></i>
            </button>
            <h5 class="mb-0 fw-bold">@yield('title', 'Dashboard')</h5>
            
            <div class="d-flex align-items-center">
                <span class="me-3 text-muted small d-none d-md-inline">{{ Auth::user()->name }}</span>
                <div class="bg-light p-2 rounded-circle">
                    <i class="bi bi-person text-primary"></i>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="content">
            <!-- Flash messages avec design flottant -->
            @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @yield('content')
        </main>
        
        <footer class="footer bg-white py-4 mt-auto border-top">
            <div class="container-fluid d-flex justify-content-between px-4">
                <span class="text-muted small">© {{ date('Y') }} Bopda Manager.</span>
                <span class="text-muted small">Version 1.0</span>
            </div>
        </footer>
    </div>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Petit script pour le toggle sidebar sur mobile
    document.getElementById('sidebarToggle')?.addEventListener('click', function() {
        document.getElementById('sidebar').classList.toggle('active');
    });
</script>
</body>
</html>