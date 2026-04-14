<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - FoodApp</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 font-sans">
    <div class="flex h-screen overflow-hidden">
        <div class="w-64 bg-slate-900 text-white flex-shrink-0">
            <div class="p-6 text-2xl font-bold border-b border-slate-800">
                Admin<span class="text-blue-400">Panel</span>
            </div>
            <nav class="mt-6">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center py-3 px-6 hover:bg-slate-800 {{ request()->routeIs('admin.dashboard') ? 'bg-slate-800 border-l-4 border-blue-500' : '' }}">
                    <i class="fas fa-chart-line mr-3"></i> Dashboard
                </a>
                <a href="{{ route('admin.users.index') }}" class="flex items-center py-3 px-6 hover:bg-slate-800 {{ request()->routeIs('admin.users.*') ? 'bg-slate-800 border-l-4 border-blue-500' : '' }}">
                    <i class="fas fa-users mr-3"></i> Users
                </a>
                <a href="{{ route('admin.categories.index') }}" class="flex items-center py-3 px-6 hover:bg-slate-800 {{ request()->routeIs('admin.categories.*') ? 'bg-slate-800 border-l-4 border-blue-500' : '' }}">
                    <i class="fas fa-list mr-3"></i> Categories
                </a>
                <a href="{{ route('admin.payments.index') }}" class="flex items-center py-3 px-6 hover:bg-slate-800 {{ request()->routeIs('admin.payments.*') ? 'bg-slate-800 border-l-4 border-blue-500' : '' }}">
                    <i class="fas fa-credit-card mr-3"></i> Payments
                </a>
                <a href="{{ route('admin.orders.index') }}" class="flex items-center py-3 px-6 hover:bg-slate-800 {{ request()->routeIs('admin.orders.*') ? 'bg-slate-800 border-l-4 border-blue-500' : '' }}">
        <i class="fas fa-shopping-basket mr-3"></i> Orders
    </a>
            </nav>
        </div>

        <div class="flex-1 flex flex-col overflow-y-auto">
            <header class="bg-white shadow-sm py-4 px-8 flex justify-between items-center">
                <h1 class="text-xl font-semibold text-gray-800">@yield('title')</h1>
                <div class="flex items-center">
                    <span class="mr-4 text-gray-600">{{ auth()->user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-red-500 hover:text-red-700 font-medium">Logout</button>
                    </form>
                </div>
            </header>

            <main class="p-8">
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>