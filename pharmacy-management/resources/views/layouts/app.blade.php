<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pharmacy Management') - Система за аптека</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .sidebar-link {
            @apply flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-gray-900 transition-colors duration-200;
        }
        .sidebar-link.active {
            @apply bg-blue-50 text-blue-700 border-r-4 border-blue-700;
        }
    </style>
</head>
<body class="bg-gray-50">
    @auth
        <div class="flex h-screen">
            <!-- Sidebar -->
            <div class="w-64 bg-white shadow-lg">
                <div class="p-4 border-b">
                    <h1 class="text-xl font-bold text-gray-800">
                        <i class="fas fa-pills text-blue-600 mr-2"></i>
                        Pharmacy Management
                    </h1>
                </div>
                
                <nav class="mt-4">
                    <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt w-5 mr-3"></i>
                        Табло
                    </a>
                    
                    <a href="{{ route('medicines.index') }}" class="sidebar-link {{ request()->routeIs('medicines.*') ? 'active' : '' }}">
                        <i class="fas fa-capsules w-5 mr-3"></i>
                        Лекарства
                    </a>
                    
                    <a href="{{ route('sales.index') }}" class="sidebar-link {{ request()->routeIs('sales.*') ? 'active' : '' }}">
                        <i class="fas fa-shopping-cart w-5 mr-3"></i>
                        Продажби
                    </a>
                    
                    <a href="{{ route('deliveries.index') }}" class="sidebar-link {{ request()->routeIs('deliveries.*') ? 'active' : '' }}">
                        <i class="fas fa-truck w-5 mr-3"></i>
                        Доставки
                    </a>
                    
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('users.index') }}" class="sidebar-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                            <i class="fas fa-users w-5 mr-3"></i>
                            Потребители
                        </a>
                    @endif
                    
                    <div class="border-t mt-4 pt-4">
                        <a href="{{ route('sales.reports') }}" class="sidebar-link">
                            <i class="fas fa-chart-line w-5 mr-3"></i>
                            Отчети
                        </a>
                    </div>
                </nav>
                
                <!-- User Profile -->
                <div class="absolute bottom-0 w-64 p-4 border-t bg-gray-50">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500">{{ auth()->user()->role }}</p>
                        </div>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" class="mt-3">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded">
                            <i class="fas fa-sign-out-alt mr-2"></i>
                            Изход
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="flex-1 overflow-auto">
                <!-- Top Bar -->
                <header class="bg-white shadow-sm border-b">
                    <div class="px-6 py-4">
                        <h2 class="text-2xl font-semibold text-gray-800">@yield('title', 'Табло за управление')</h2>
                    </div>
                </header>
                
                <!-- Page Content -->
                <main class="p-6">
                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                            {{ session('error') }}
                        </div>
                    @endif
                    
                    @yield('content')
                </main>
            </div>
        </div>
    @else
        @yield('content')
    @endauth
</body>
</html>
