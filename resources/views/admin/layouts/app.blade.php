<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Admin Sistem Kolam Renang</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .pool-background {
            background-image: url('{{ asset('kolam1.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
        }
        
        .glass-sidebar {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            border-right: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }
        
        .glass-header {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }
        
        .glass-content {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }
        
        .sidebar-active {
            background-color: rgba(59, 130, 246, 0.3);
            border-right: 4px solid #3b82f6;
        }
        
        /* Mobile sidebar overlay */
        .sidebar-overlay {
            backdrop-filter: blur(4px);
        }
        
        /* Smooth transitions */
        .sidebar-transition {
            transition: transform 0.3s ease-in-out;
        }
    </style>
</head>
<body class="pool-background">
    <div class="flex h-screen overflow-hidden">
        <!-- Mobile sidebar overlay -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 sidebar-overlay z-40 lg:hidden hidden"></div>
        
        <!-- Sidebar -->
        <aside id="sidebar" class="fixed lg:static inset-y-0 left-0 z-50 w-64 glass-sidebar shadow-lg transform -translate-x-full lg:translate-x-0 sidebar-transition">
            <!-- Logo -->
            <div class="h-14 sm:h-16 flex items-center justify-between px-4 border-b border-white border-opacity-20">
                <h1 class="text-lg sm:text-xl font-bold text-white">🏊‍♀️ Admin Panel</h1>
                <!-- Close button for mobile -->
                <button id="close-sidebar" class="lg:hidden p-2 rounded-md text-white text-opacity-70 hover:text-white hover:bg-white hover:bg-opacity-20">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
            
            <!-- Navigation Menu -->
            <nav class="mt-4 sm:mt-6 overflow-y-auto h-full pb-20">
                <div class="px-4 mb-3 sm:mb-4">
                    <p class="text-xs font-semibold text-white text-opacity-70 uppercase tracking-wide">Menu Utama</p>
                </div>
                
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 sm:px-6 py-2.5 sm:py-3 text-sm sm:text-base text-white hover:bg-white hover:bg-opacity-20 hover:text-white transition-colors {{ request()->routeIs('admin.dashboard') ? 'sidebar-active text-white' : '' }}">
                    <i class="fas fa-chart-pie w-4 h-4 sm:w-5 sm:h-5 mr-3"></i>
                    <span>Dashboard</span>
                </a>
                
                <a href="{{ route('admin.bookings.index') }}" class="flex items-center px-4 sm:px-6 py-2.5 sm:py-3 text-sm sm:text-base text-white hover:bg-white hover:bg-opacity-20 hover:text-white transition-colors {{ request()->routeIs('admin.bookings.*') ? 'sidebar-active text-white' : '' }}">
                    <i class="fas fa-calendar-check w-4 h-4 sm:w-5 sm:h-5 mr-3"></i>
                    <span>Kelola Booking</span>
                    @if(isset($pendingBookings) && $pendingBookings > 0)
                        <span class="ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full">{{ $pendingBookings }}</span>
                    @endif
                </a>
                
                <a href="{{ route('admin.users') }}" class="flex items-center px-4 sm:px-6 py-2.5 sm:py-3 text-sm sm:text-base text-white hover:bg-white hover:bg-opacity-20 hover:text-white transition-colors {{ request()->routeIs('admin.users') ? 'sidebar-active text-white' : '' }}">
                    <i class="fas fa-users w-4 h-4 sm:w-5 sm:h-5 mr-3"></i>
                    <span>Kelola User</span>
                </a>
                
                <div class="px-4 mt-4 sm:mt-6 mb-3 sm:mb-4">
                    <p class="text-xs font-semibold text-white text-opacity-70 uppercase tracking-wide">Lainnya</p>
                </div>
                
                <a href="{{ route('admin.profile') }}" class="flex items-center px-4 sm:px-6 py-2.5 sm:py-3 text-sm sm:text-base text-white hover:bg-white hover:bg-opacity-20 hover:text-white transition-colors {{ request()->routeIs('admin.profile') ? 'sidebar-active text-white' : '' }}">
                    <i class="fas fa-user-cog w-4 h-4 sm:w-5 sm:h-5 mr-3"></i>
                    <span>Profile</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col w-0 lg:ml-0">
            <!-- Top Navigation Bar -->
            <header class="glass-header shadow-sm border-b border-white border-opacity-20 relative">
                <div class="flex items-center justify-between h-14 sm:h-16 px-4 sm:px-6">
                    <div class="flex items-center">
                        <!-- Mobile menu button -->
                        <button id="mobile-menu-btn" class="lg:hidden p-2 -ml-2 rounded-md text-white text-opacity-70 hover:text-white hover:bg-white hover:bg-opacity-20 mr-2">
                            <i class="fas fa-bars text-lg"></i>
                        </button>
                        
                        <div>
                            <h2 class="text-lg sm:text-2xl font-semibold text-white">@yield('page-title', 'Dashboard')</h2>
                            <p class="hidden sm:block text-sm text-white text-opacity-80">@yield('page-description', 'Selamat datang di panel admin')</p>
                        </div>
                    </div>
                    
                    <!-- User Menu -->
                    <div class="flex items-center space-x-2 sm:space-x-4">
                        <!-- User info - hidden on mobile, show on sm+ -->
                        <div class="hidden sm:block text-right">
                            <p class="text-sm font-medium text-white">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-white text-opacity-70">Administrator</p>
                        </div>
                        
                        <!-- User avatar -->
                        <div class="h-7 w-7 sm:h-8 sm:w-8 bg-blue-500 rounded-full flex items-center justify-center">
                            <span class="text-white text-xs sm:text-sm font-bold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                        </div>
                        
                        <!-- Logout button -->
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-2 sm:px-4 py-1.5 sm:py-2 rounded-md sm:rounded-lg text-xs sm:text-sm transition-colors">
                                <i class="fas fa-sign-out-alt mr-0 sm:mr-1"></i>
                                <span class="hidden sm:inline">Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto glass-content p-3 sm:p-4 lg:p-6">
                <!-- Alert Messages -->
                @if(session('success'))
                    <div class="mb-4 sm:mb-6 p-3 sm:p-4 glass-card border border-green-400 text-white rounded-lg flex items-center text-sm sm:text-base">
                        <i class="fas fa-check-circle mr-2 flex-shrink-0"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="mb-4 sm:mb-6 p-3 sm:p-4 glass-card border border-red-400 text-white rounded-lg flex items-center text-sm sm:text-base">
                        <i class="fas fa-exclamation-circle mr-2 flex-shrink-0"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Mobile sidebar functionality
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebar-overlay');
        const closeSidebar = document.getElementById('close-sidebar');

        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            sidebar.classList.add('translate-x-0');
            sidebarOverlay.classList.remove('hidden');
            document.body.classList.add('overflow-hidden', 'lg:overflow-auto');
        }

        function closeSidebarFn() {
            sidebar.classList.add('-translate-x-full');
            sidebar.classList.remove('translate-x-0');
            sidebarOverlay.classList.add('hidden');
            document.body.classList.remove('overflow-hidden', 'lg:overflow-auto');
        }

        // Event listeners
        mobileMenuBtn?.addEventListener('click', openSidebar);
        closeSidebar?.addEventListener('click', closeSidebarFn);
        sidebarOverlay?.addEventListener('click', closeSidebarFn);

        // Close sidebar when clicking on sidebar links (mobile)
        const sidebarLinks = sidebar?.querySelectorAll('a');
        sidebarLinks?.forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 1024) { // Only on mobile/tablet
                    closeSidebarFn();
                }
            });
        });

        // Handle window resize
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                closeSidebarFn();
            }
        });

        // Auto hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.bg-green-100.border, .bg-red-100.border');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);

        // Prevent body scroll when sidebar is open on mobile
        function preventBodyScroll(e) {
            if (window.innerWidth < 1024 && !sidebarOverlay?.classList.contains('hidden')) {
                e.preventDefault();
            }
        }

        document.addEventListener('touchmove', preventBodyScroll, { passive: false });
    </script>
</body>
</html> 