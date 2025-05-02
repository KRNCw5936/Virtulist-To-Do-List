<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'VIRTULIST')</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        :root {
            --sidebar-width: 280px;
            --sidebar-collapsed-width: 80px;
            --primary-color: #4361ee;
            --primary-light: #e6f0ff;
            --text-color: #2b2b2b;
            --text-light: #6c757d;
            --transition-speed: 0.3s;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --border-radius: 12px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f8f9fa;
            color: var(--text-color);
            min-height: 100vh;
            transition: all var(--transition-speed) ease;
        }

        /* Layout Structure */
        .app-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            background: white;
            box-shadow: var(--shadow);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            transition: all var(--transition-speed) ease;
            overflow-y: auto;
            padding: 20px 0;
            display: flex;
            flex-direction: column;
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
            overflow: hidden;
        }

        .sidebar.collapsed .brand,
        .sidebar.collapsed .nav-text,
        .sidebar.collapsed .logout-text {
            display: none;
        }

        .sidebar.collapsed a {
            justify-content: center;
            padding: 12px 0;
        }

        .sidebar.collapsed .notif-wrapper {
            justify-content: center;
        }

        .brand {
            font-weight: bold;
            font-size: 1.8rem;
            text-align: center;
            margin-bottom: 30px;
            padding: 0 20px;
            color: var(--primary-color);
            transition: all var(--transition-speed) ease;
        }

        .nav-menu {
            flex-grow: 1;
            overflow-y: auto;
            padding: 0 10px;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: var(--text-color);
            text-decoration: none;
            margin: 5px 0;
            border-radius: var(--border-radius);
            transition: all var(--transition-speed) ease;
            position: relative;
        }

        .sidebar a i {
            margin-right: 12px;
            font-size: 1.1rem;
            min-width: 24px;
            text-align: center;
            transition: all var(--transition-speed) ease;
        }

        .sidebar a:hover {
            background-color: var(--primary-light);
            color: var(--primary-color);
            transform: translateX(5px);
        }

        .sidebar a.active {
            background-color: var(--primary-light);
            color: var(--primary-color);
            font-weight: 500;
        }

        .sidebar a.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background-color: var(--primary-color);
            border-radius: 0 var(--border-radius) var(--border-radius) 0;
        }

        /* Notification Styles */
        .notif-wrapper {
            padding: 0 20px;
            margin-bottom: 20px;
        }

        .notif-box {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: var(--text-color);
            transition: all var(--transition-speed) ease;
        }

        .notif-box:hover {
            color: var(--primary-color);
        }

        .badge {
            font-size: 0.6rem;
        }

        /* Logout Button */
        .logout-btn {
            margin: 20px;
            padding: 10px;
            border-radius: var(--border-radius);
            background-color: #f8f9fa;
            transition: all var(--transition-speed) ease;
        }

        .logout-btn:hover {
            background-color: #f1f1f1;
        }

        /* Main Content */
        .content-wrapper {
            flex-grow: 1;
            margin-left: var(--sidebar-width);
            padding: 20px;
            transition: all var(--transition-speed) ease;
            min-height: 100vh;
        }

        .content-wrapper.collapsed {
            margin-left: var(--sidebar-collapsed-width);
        }

        /* Toggle Button */
        .sidebar-toggle {
            position: fixed;
            left: 20px;
            top: 20px;
            z-index: 1100;
            background: white;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--shadow);
            cursor: pointer;
            transition: all var(--transition-speed) ease;
            opacity: 0.8;
        }

        .sidebar-toggle:hover {
            opacity: 1;
            transform: scale(1.1);
        }

        .sidebar-toggle i {
            font-size: 1.2rem;
            color: var(--text-color);
        }

        /* Footer */
        .footer {
            text-align: center;
            padding: 15px;
            font-size: 14px;
            background-color: white;
            border-top: 1px solid #ddd;
            margin-left: var(--sidebar-width);
            transition: all var(--transition-speed) ease;
        }

        .footer.collapsed {
            margin-left: var(--sidebar-collapsed-width);
        }

        .social-icons a {
            color: var(--text-light);
            font-size: 20px;
            margin: 0 10px;
            transition: 0.3s;
        }

        .social-icons a:hover {
            color: var(--primary-color);
        }

        /* Mobile Styles */
        @media (max-width: 992px) {
            .sidebar {
                left: calc(-1 * var(--sidebar-width));
            }

            .sidebar.collapsed {
                left: 0;
                width: var(--sidebar-collapsed-width);
            }

            .sidebar.show {
                left: 0;
            }

            .content-wrapper {
                margin-left: 0;
            }

            .content-wrapper.collapsed {
                margin-left: 0;
            }

            .footer {
                margin-left: 0;
            }

            .footer.collapsed {
                margin-left: 0;
            }

            .sidebar-toggle {
                display: flex;
            }
        }

        @media (min-width: 993px) {
            .sidebar-toggle {
                display: none;
            }
        }

        /* Smooth transitions */
        .transition-all {
            transition: all var(--transition-speed) ease;
        }
    </style>
</head>
<body>
    <div class="app-container">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <a href="{{ route('homepage.dashboard') }}" class="brand">VIRTULIST</a>
            
            @auth
            <div class="nav-menu">
                <div class="notif-wrapper d-flex align-items-center">
                    <a href="{{ route('homepage.notif') }}" class="notif-box">
                        <i class="bi bi-bell fs-5 @if($notifCount > 0) text-danger @endif"></i>
                        <span class="nav-text ms-2">Notifications</span>
                        @if($notifCount > 0)
                            <span class="ms-2 badge rounded-pill bg-danger">
                                {{ $notifCount }}
                            </span>
                        @endif
                    </a>
                </div>
                
                <a href="{{ route('homepage.dashboard') }}" class="@if(request()->routeIs('homepage.dashboard')) active @endif">
                    <i class="fas fa-tachometer-alt"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
                <a href="{{ route('homepage.home') }}" class="@if(request()->routeIs('homepage.home')) active @endif">
                    <i class="fas fa-plus-circle"></i>
                    <span class="nav-text">Create To-Do</span>
                </a>
                <a href="{{ route('task-lists.index') }}" class="@if(request()->routeIs('task-lists.index')) active @endif">
                    <i class="fas fa-list-ul"></i>
                    <span class="nav-text">List Tasks</span>
                </a>
                <a href="{{ route('calendar.index') }}" class="@if(request()->routeIs('calendar.index')) active @endif">
                    <i class="fas fa-calendar-alt"></i>
                    <span class="nav-text">Calendar</span>
                </a>
                <a href="{{ route('task-lists.completed') }}" class="@if(request()->routeIs('task-lists.completed')) active @endif">
                    <i class="fas fa-check-circle"></i>
                    <span class="nav-text">Completed Task</span>
                </a>
            </div>
            
            <form action="{{ route('logout') }}" method="POST" class="logout-btn">
                @csrf
                <button type="submit" class="btn btn-link text-decoration-none p-0 d-flex align-items-center w-100">
                    <i class="bi bi-box-arrow-right me-2"></i>
                    <span class="logout-text">Log Out</span>
                </button>
            </form>
            @endauth
        </div>

        <!-- Main Content -->
        <div class="content-wrapper" id="content-container">
            <!-- Toggle Button (visible on mobile) -->
            <button class="sidebar-toggle" id="sidebarToggle">
                <i class="bi bi-list"></i>
            </button>
            
            @yield('content')
            @vite(['resources/js/app.js'])
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer" id="footer">
        <p class="mb-2">© 2025 Adrian Baihaqi. All rights reserved.</p>
        <div class="social-icons">
            <a href="https://www.linkedin.com/in/adrian-baihaqi-069a71303/" target="_blank"><i class="bi bi-linkedin"></i></a>
            <a href="https://github.com/KRNCw5936" target="_blank"><i class="bi bi-github"></i></a>
            <a href="https://www.instagram.com/adrian_portofolio" target="_blank"><i class="bi bi-instagram"></i></a>
        </div>
    </footer>

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('content-container');
            const footer = document.getElementById('footer');
            const toggleBtn = document.getElementById('sidebarToggle');
            let isCollapsed = false;

            // Check localStorage for collapsed state
            if (localStorage.getItem('sidebarCollapsed') === 'true') {
                toggleCollapse();
            }

            // Toggle sidebar collapse
            function toggleCollapse() {
                isCollapsed = !isCollapsed;
                
                if (window.innerWidth > 992) {
                    // Desktop behavior
                    sidebar.classList.toggle('collapsed');
                    content.classList.toggle('collapsed');
                    footer.classList.toggle('collapsed');
                } else {
                    // Mobile behavior
                    sidebar.classList.toggle('show');
                }
                
                // Save state to localStorage
                localStorage.setItem('sidebarCollapsed', isCollapsed);
            }

            // Toggle button click event
            toggleBtn.addEventListener('click', toggleCollapse);

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(event) {
                if (window.innerWidth <= 992 && isCollapsed) {
                    const isClickInsideSidebar = sidebar.contains(event.target);
                    const isClickOnToggle = toggleBtn.contains(event.target);
                    
                    if (!isClickInsideSidebar && !isClickOnToggle) {
                        toggleCollapse();
                    }
                }
            });

            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth > 992) {
                    // Desktop - ensure sidebar is visible
                    sidebar.classList.remove('show');
                    if (isCollapsed) {
                        sidebar.classList.add('collapsed');
                        content.classList.add('collapsed');
                        footer.classList.add('collapsed');
                    } else {
                        sidebar.classList.remove('collapsed');
                        content.classList.remove('collapsed');
                        footer.classList.remove('collapsed');
                    }
                } else {
                    // Mobile - start with sidebar hidden
                    if (!isCollapsed) {
                        sidebar.classList.remove('show');
                    }
                }
            });
        });
    </script>
</body>
</html>