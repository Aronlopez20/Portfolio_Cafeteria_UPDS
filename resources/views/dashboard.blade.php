{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Welcome Header -->
        <div class="bg-gradient-to-r from-orange-500 to-red-600 rounded-lg shadow-xl p-8 mb-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold mb-2">👋 ¡Bienvenido, {{ Auth::user()->name }}!</h1>
                    <p class="text-orange-100 text-lg">
                        🎓 Tu cafetería universitaria favorita te espera
                    </p>
                    <p class="text-orange-100 mt-1">
                        📅 {{ now()->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}
                    </p>
                </div>
                <div class="text-8xl opacity-20">
                    ☕
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Total Orders -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="text-3xl text-orange-500 mr-4">📊</div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Mis Pedidos</h3>
                        <p class="text-3xl font-bold text-orange-600">{{ Auth::user()->orders->count() }}</p>
                        <p class="text-sm text-gray-500">Total de pedidos realizados</p>
                    </div>
                </div>
            </div>

            <!-- Active Orders -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="text-3xl text-green-500 mr-4">🚀</div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Pedidos Activos</h3>
                        <p class="text-3xl font-bold text-green-600">
                            {{ Auth::user()->orders()->whereIn('status', ['pending', 'confirmed', 'preparing', 'ready'])->count() }}
                        </p>
                        <p class="text-sm text-gray-500">En proceso</p>
                    </div>
                </div>
            </div>

            <!-- Cart Items -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="text-3xl text-purple-500 mr-4">🛒</div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">En Carrito</h3>
                        <p class="text-3xl font-bold text-purple-600">
                            {{ session('cart') ? array_sum(session('cart')) : 0 }}
                        </p>
                        <p class="text-sm text-gray-500">Items seleccionados</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <!-- Menu Access -->
            <div class="bg-white rounded-lg shadow-md p-8 text-center">
                <div class="text-6xl mb-4">🍽️</div>
                <h3 class="text-2xl font-semibold text-gray-900 mb-2">Explorar Menú</h3>
                <p class="text-gray-600 mb-6">Descubre nuestras deliciosas opciones del día</p>
                <a href="{{ route('menu.index') }}" 
                   class="bg-gradient-to-r from-orange-500 to-red-600 hover:from-orange-600 hover:to-red-700 text-white font-bold py-3 px-6 rounded-lg transition duration-150">
                    🚀 Ver Menú Completo
                </a>
            </div>

            <!-- My Orders -->
            <div class="bg-white rounded-lg shadow-md p-8 text-center">
                <div class="text-6xl mb-4">📋</div>
                <h3 class="text-2xl font-semibold text-gray-900 mb-2">Mis Pedidos</h3>
                <p class="text-gray-600 mb-6">Revisa el estado de tus pedidos anteriores</p>
                <a href="{{ route('orders.index') }}" 
                   class="bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-bold py-3 px-6 rounded-lg transition duration-150">
                    📊 Ver Historial
                </a>
            </div>
        </div>

        <!-- Recent Orders -->
        @if(Auth::user()->orders->count() > 0)
            <div class="bg-white rounded-lg shadow-md p-8">
                <h3 class="text-2xl font-semibold text-gray-900 mb-6 flex items-center">
                    🕒 Pedidos Recientes
                </h3>
                
                <div class="space-y-4">
                    @foreach(Auth::user()->orders()->latest()->take(3)->get() as $order)
                        <div class="flex justify-between items-center py-4 px-6 bg-gray-50 rounded-lg">
                            <div>
                                <h4 class="font-semibold text-gray-900">🧾 {{ $order->order_number }}</h4>
                                <p class="text-sm text-gray-600">
                                    📅 {{ $order->created_at->locale('es')->isoFormat('D [de] MMMM, HH:mm') }}
                                </p>
                                <p class="text-sm text-gray-500">
                                    📦 {{ $order->orderItems->count() }} {{ $order->orderItems->count() == 1 ? 'item' : 'items' }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-orange-600">{{ $order->formatted_total }}</p>
                                @switch($order->status)
                                    @case('pending')
                                        <span class="inline-block bg-yellow-500 text-white px-2 py-1 rounded-full text-xs">
                                            ⏳ Pendiente
                                        </span>
                                        @break
                                    @case('confirmed')
                                        <span class="inline-block bg-blue-500 text-white px-2 py-1 rounded-full text-xs">
                                            ✅ Confirmado
                                        </span>
                                        @break
                                    @case('preparing')
                                        <span class="inline-block bg-orange-500 text-white px-2 py-1 rounded-full text-xs">
                                            👨‍🍳 Preparando
                                        </span>
                                        @break
                                    @case('ready')
                                        <span class="inline-block bg-green-500 text-white px-2 py-1 rounded-full text-xs">
                                            🎉 Listo
                                        </span>
                                        @break
                                    @case('completed')
                                        <span class="inline-block bg-gray-600 text-white px-2 py-1 rounded-full text-xs">
                                            ✨ Completado
                                        </span>
                                        @break
                                @endswitch
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-6 text-center">
                    <a href="{{ route('orders.index') }}" 
                       class="text-orange-600 hover:text-orange-800 font-medium">
                        👁️ Ver todos los pedidos →
                    </a>
                </div>
            </div>
        @endif

        <!-- Cart Preview -->
        @if(session('cart') && count(session('cart')) > 0)
            <div class="bg-green-50 border border-green-200 rounded-lg p-6 mt-8">
                <h3 class="text-lg font-semibold text-green-800 mb-4 flex items-center">
                    🛒 Tienes items en tu carrito
                </h3>
                <p class="text-green-700 mb-4">
                    {{ array_sum(session('cart')) }} {{ array_sum(session('cart')) == 1 ? 'item agregado' : 'items agregados' }} esperando confirmación
                </p>
                <div class="flex space-x-4">
                    <a href="{{ route('orders.create') }}" 
                       class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md font-medium transition duration-150">
                        🚀 Finalizar Pedido
                    </a>
                    <a href="{{ route('menu.index') }}" 
                       class="bg-white hover:bg-gray-50 text-green-700 border border-green-300 px-4 py-2 rounded-md font-medium transition duration-150">
                        ➕ Agregar Más Items
                    </a>
                </div>
            </div>
        @endif

        <!-- University Info -->
        <div class="bg-gray-100 rounded-lg p-6 mt-8 text-center">
            <h3 class="text-xl font-semibold text-gray-800 mb-2">🎓 Universidad Privada Domingo Savio</h3>
            <p class="text-gray-600">La Paz - Bolivia 🇧🇴</p>
            <p class="text-sm text-gray-500 mt-2">
                Horario de Cafetería: Lunes a Viernes, 7:00 AM - 6:00 PM
            </p>
        </div>
    </div>
</div>
@endsection