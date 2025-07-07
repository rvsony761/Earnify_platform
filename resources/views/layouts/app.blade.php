<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Earning Platform')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="text-xl font-bold text-primary-600">Earning Platform</a>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                    @if(auth()->user()->is_admin)
                        
                        <a href="{{route('admin.dashboard')}}" class="text-gray-700 hover:text-primary-600">Admin</a>
                    @else
                        <a href="{{route('user.dashboard')}}" class="text-gray-700 hover:text-primary-600">Dashboard</a>
                    @endif
                        <form method="POST" action="{{route('user.logout')}}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-700 hover:text-primary-600">Logout</button>
                        </form>
                    @else
                        <a href="{{route('user.login')}}" class="text-gray-700 hover:text-primary-600">Login</a>
                        <a href="{{route('user.register')}}" class="bg-primary-600 text-white px-4 py-2 rounded-md hover:bg-primary-700">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>
    @include('layouts.footer')
</body>
</html>
