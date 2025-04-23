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
        html, body {
            height: 100%;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }

        .content-wrapper {
            flex-grow: 1;
            margin-left: 250px;
            padding-top: 20px;
            transition: margin-left 0.3s ease-in-out;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100%;
            background: white;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
            padding-top: 20px;
            z-index: 1000;
            transition: left 0.3s ease-in-out;
        }

        .sidebar .brand {
            font-weight: bold;
            font-size: 1.8rem;
            text-align: center;
            display: block;
            margin-bottom: 20px;
        }

        .sidebar a {
            display: block;
            padding: 12px 20px;
            color: #333;
            text-decoration: none;
            transition: background 0.3s ease, color 0.3s ease, transform 0.2s ease;
            position: relative;
            border-radius: 8px;
            margin: 5px 10px;
            font-weight: normal;
        }

        .sidebar a:hover {
            background: rgba(0, 0, 0, 0.05);
            transform: translateX(4px);
            color: #000;
        }

        .sidebar a.active {
            background: transparent;
            color: #000;
            font-weight: 500;
            position: relative;
        }

        .sidebar a.active::after {
            content: "";
            position: absolute;
            bottom: 4px;
            left: 20px;
            right: 20px;
            height: 2px;
            background-color: #000;
            border-radius: 2px;
        }


        .sidebar-toggle {
            display: none;
        }

        .footer {
            text-align: center;
            padding: 15px;
            font-size: 14px;
            background-color: white;
            border-top: 1px solid #ddd;
            position: relative;
            left: 140px;
        }

        .footer .social-icons a {
            color: black;
            font-size: 20px;
            margin: 0 10px;
            transition: 0.3s;
        }

        .footer .social-icons a:hover {
            color: #000;
        }

        @media (max-width: 768px) {
            .sidebar {
                left: -250px;
            }

            .sidebar-toggle {
                display: block;
                font-size: 24px;
                cursor: pointer;
                background: none;
                border: none;
                padding: 10px;
                position: fixed;
                left: 10px;
                top: 15px;
                z-index: 1100;
            }

            .content-wrapper {
                margin-left: 0;
                padding-top: 60px;
            }

            .footer {
                left: 0;
                text-align: center;
            }

            .notif-box {
                background-color: #ffffff;
                padding: 8px 12px;
                border-radius: 10px;
                box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <a href="{{ route('homepage.dashboard') }}" class="brand">VIRTULIST</a>
        @auth

        <div class="notif-wrapper me-3 position-relative">
            <a href="{{ route('homepage.notif') }}" class="notif-box d-inline-block text-decoration-none">
                <i class="bi bi-bell fs-4 @if($notifCount > 0) text-danger @endif"></i>
                @if($notifCount > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ $notifCount }}
                    </span>
                @endif
            </a>
        </div>        
                
        <a href="{{ route('homepage.dashboard') }}" class="ajax-link @if(request()->routeIs('homepage.dashboard')) active @endif">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
        <a href="{{ route('homepage.home') }}" class="ajax-link @if(request()->routeIs('homepage.home')) active @endif">
            <i class="fas fa-plus-circle"></i> Create To-Do
        </a>
        <a href="{{ route('task-lists.index') }}" class="ajax-link @if(request()->routeIs('task-lists.index')) active @endif">
            <i class="fas fa-list-ul"></i> List Tasks
        </a>
        <a href="{{ route('calendar.index') }}" class="ajax-link @if(request()->routeIs('calendar.index')) active @endif">
            <i class="fas fa-calendar-alt"></i> Calendar
        </a>
        <a href="{{ route('task-lists.completed') }}" class="ajax-link @if(request()->routeIs('task-lists.completed')) active @endif">
            <i class="fas fa-check-circle"></i> Completed Task
        </a>
              
        <form action="{{ route('logout') }}" method="POST" class="d-flex align-items-center mt-3 px-3">
            @csrf
            <button type="submit" class="btn btn-danger btn-sm px-4 d-flex align-items-center w-100">
                <i class="bi bi-box-arrow-right me-2"></i> Log Out
            </button>
        </form>        
        @endauth
    </div>

    <!-- Tombol Toggle Sidebar -->
    <button class="sidebar-toggle" onclick="toggleSidebar()">
        <i class="bi bi-list"></i>
    </button>

    <!-- Konten Utama -->
    <div class="content-wrapper container mt-4" id="content-container">
        @yield('content')
        @vite(['resources/js/app.js'])
    </div>

    <!-- Footer -->
    <footer class="footer">
        <p class="mb-2">© 2025 Adrian Baihaqi. All rights reserved.</p>
        <div class="social-icons">
            <a href="https://www.linkedin.com/in/adrian-baihaqi-069a71303/" target="_blank"><i class="bi bi-linkedin"></i></a>
            <a href="https://github.com/KRNCw5936" target="_blank"><i class="bi bi-github"></i></a>
            <a href="https://www.instagram.com/adrian_portofolio" target="_blank"><i class="bi bi-instagram"></i></a>
        </div>
    </footer>

    <!-- Script Sidebar Toggle -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById("sidebar");
            if (sidebar.style.left === "0px") {
                sidebar.style.left = "-250px";
            } else {
                sidebar.style.left = "0px";
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>