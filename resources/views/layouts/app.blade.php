{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>☕ Cafetería UPDS - @yield('title', 'Tu cafetería universitaria')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-orange-50">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-gradient-to-r from-orange-600 to-red-600 shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <!-- Logo -->
                        <div class="flex-shrink-0 flex items-center">
                            <a href="{{ route('menu.index') }}" class="text-white font-bold text-xl">
                                ☕ Cafetería UPDS
                            </a>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <a href="{{ route('menu.index') }}" 
                               class="text-white hover:text-orange-200 px-3 py-2 text-sm font-medium transition duration-150">
                                🍽️ Menú
                            </a>
                            @auth
                                <a href="{{ route('orders.index') }}" 
                                   class="text-white hover:text-orange-200 px-3 py-2 text-sm font-medium transition duration-150">
                                    📋 Mis Pedidos
                                </a>
                            @endauth
                        </div>
                    </div>

                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        @auth
                            <!-- Cart Icon -->
                            @php
                                $cartCount = session('cart') ? array_sum(session('cart')) : 0;
                            @endphp
                            @if($cartCount > 0)
                                <a href="{{ route('orders.create') }}" 
                                   class="relative text-white hover:text-orange-200 mr-4 transition duration-150">
                                    🛒 <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">{{ $cartCount }}</span>
                                </a>
                            @endif

                            <!-- Settings Dropdown -->
                            <div class="ml-3 relative">
                                <div class="flex items-center space-x-4">
                                    <span class="text-white text-sm">👋 Hola, {{ Auth::user()->name }}!</span>
                                    <form method="POST" action="{{ route('logout') }}" class="inline">
                                        @csrf
                                        <button type="submit" class="text-white hover:text-orange-200 text-sm transition duration-150">
                                            🚪 Salir
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <!-- Guest Links -->
                            <div class="flex space-x-4">
                                <a href="{{ route('login') }}" class="text-white hover:text-orange-200 px-3 py-2 text-sm font-medium transition duration-150">
                                    🔑 Iniciar Sesión
                                </a>
                                <a href="{{ route('register') }}" class="bg-white text-orange-600 hover:bg-orange-100 px-4 py-2 rounded-md text-sm font-medium transition duration-150">
                                    📝 Registrarse
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main>
            <!-- Flash Messages -->
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mx-4 mt-4">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mx-4 mt-4">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-gray-800 text-white py-8 mt-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <p class="text-lg font-semibold">☕ Cafetería UPDS</p>
                    <p class="text-gray-400 mt-2">Universidad Privada Domingo Savio - La Paz, Bolivia 🇧🇴</p>
                    <p class="text-gray-400 mt-1">Horario: Lunes a Viernes 7:00 - 18:00</p>
                    <p class="text-gray-400 mt-2">📧 cafeteria@upds.edu.bo | 📞 2-2500000</p>
                    <p class="text-sm text-gray-500 mt-4">
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
