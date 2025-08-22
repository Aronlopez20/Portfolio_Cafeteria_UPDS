{{-- resources/views/kitchen/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard Cocina')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Welcome Header -->
        <div class="bg-gradient-to-r from-orange-600 to-red-700 rounded-lg shadow-xl p-6 mb-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold mb-2">👨‍🍳 Dashboard de Cocina</h1>
                    <p class="text-orange-100 text-lg">
                        ¡Hola {{ Auth::user()->name }}! - Gestión de Pedidos
                    </p>
                </div>
                <div class="text-6xl opacity-20">🔥</div>
            </div>
        </div>

        <!-- Stats Row -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-yellow-100 rounded-lg p-4 text-center">
                <div class="text-2xl text-yellow-600 mb-2">⏳</div>
                <h3 class="text-lg font-semibold text-yellow-800">Pendientes</h3>
                <p class="text-2xl font-bold text-yellow-900">{{ $stats['pending_count'] }}</p>
            </div>
            
            <div class="bg-blue-100 rounded-lg p-4 text-center">
                <div class="text-2xl text-blue-600 mb-2">👨‍🍳</div>
                <h3 class="text-lg font-semibold text-blue-800">Preparando</h3>
                <p class="text-2xl font-bold text-blue-900">{{ $stats['preparing_count'] }}</p>
            </div>
            
            <div class="bg-green-100 rounded-lg p-4 text-center">
                <div class="text-2xl text-green-600 mb-2">🎉</div>
                <h3 class="text-lg font-semibold text-green-800">Listos</h3>
                <p class="text-2xl font-bold text-green-900">{{ $stats['ready_count'] }}</p>
            </div>
            
            <div class="bg-purple-100 rounded-lg p-4 text-center">
                <div class="text-2xl text-purple-600 mb-2">⏱️</div>
                <h3 class="text-lg font-semibold text-purple-800">Tiempo Promedio</h3>
                <p class="text-2xl font-bold text-purple-900">{{ $stats['avg_preparation_time'] }} min</p>
            </div>
        </div>

        <!-- Orders Sections -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Pending Orders -->
            <div class="bg-white rounded-lg shadow-md">
                <div class="bg-yellow-500 text-white px-6 py-4 rounded-t-lg">
                    <h2 class="text-xl font-semibold flex items-center">
                        ⏳ Pedidos Pendientes ({{ $pendingOrders->count() }})
                    </h2>
                </div>
                <div class="p-4 max-h-96 overflow-y-auto">
                    @forelse($pendingOrders as $order)
                        <div class="border border-gray-200 rounded-lg p-4 mb-4">
                            <div class="flex justify-between items-center mb-2">
                                <h3 class="font-semibold text-gray-900">{{ $order->order_number }}</h3>
                                <span class="text-sm text-gray-500">
                                    {{ $order->created_at->locale('es')->isoFormat('HH:mm') }}
                                </span>
                            </div>
                            
                            <p class="text-sm text-gray-600 mb-2">
                                👤 {{ $order->user->name }}
                            </p>
                            
                            @if($order->scheduled_for)
                                <div class="bg-blue-50 p-2 rounded text-sm text-blue-800 mb-2">
                                    ⏰ Para: {{ $order->scheduled_for->locale('es')->isoFormat('HH:mm') }}
                                </div>
                            @endif
                            
                            <div class="mb-3">
                                @foreach($order->orderItems as $item)
                                    <p class="text-sm text-gray-700">
                                        • {{ $item->quantity }}x {{ $item->menuItem->name }}
                                    </p>
                                @endforeach
                            </div>
                            
                            @if($order->special_notes)
                                <div class="bg-yellow-50 p-2 rounded text-sm text-yellow-800 mb-3">
                                    📝 {{ $order->special_notes }}
                                </div>
                            @endif
                            
                            <div class="flex space-x-2">
                                <form action="{{ route('kitchen.orders.update-status', $order) }}" method="POST" class="flex-1">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="confirmed">
                                    <button type="submit" 
                                            class="w-full bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded text-sm transition duration-150">
                                        ✅ Confirmar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-gray-500">
                            <div class="text-4xl mb-2">😴</div>
                            <p>No hay pedidos pendientes</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Preparing Orders -->
            <div class="bg-white rounded-lg shadow-md">
                <div class="bg-blue-500 text-white px-6 py-4 rounded-t-lg">
                    <h2 class="text-xl font-semibold flex items-center">
                        👨‍🍳 En Preparación ({{ $preparingOrders->count() }})
                    </h2>
                </div>
                <div class="p-4 max-h-96 overflow-y-auto">
                    @forelse($preparingOrders as $order)
                        <div class="border border-gray-200 rounded-lg p-4 mb-4">
                            <div class="flex justify-between items-center mb-2">
                                <h3 class="font-semibold text-gray-900">{{ $order->order_number }}</h3>
                                <span class="text-sm text-gray-500">
                                    {{ $order->created_at->diffForHumans() }}
                                </span>
                            </div>
                            
                            <p class="text-sm text-gray-600 mb-2">
                                👤 {{ $order->user->name }}
                            </p>
                            
                            <div class="mb-3">
                                @foreach($order->orderItems as $item)
                                    <p class="text-sm text-gray-700">
                                        • {{ $item->quantity }}x {{ $item->menuItem->name }}
                                        <span class="text-xs text-gray-500">(~{{ $item->menuItem->preparation_time }}min)</span>
                                    </p>
                                @endforeach
                            </div>
                            
                            <form action="{{ route('kitchen.orders.update-status', $order) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="ready">
                                <button type="submit" 
                                        class="w-full bg-green-500 hover:bg-green-600 text-white px-3 py-2 rounded text-sm transition duration-150">
                                    🎉 Marcar Listo
                                </button>
                            </form>
                        </div>
                    @empty
                        <div class="text-center py-8 text-gray-500">
                            <div class="text-4xl mb-2">🍳</div>
                            <p>No hay pedidos en preparación</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Ready Orders -->
            <div class="bg-white rounded-lg shadow-md">
                <div class="bg-green-500 text-white px-6 py-4 rounded-t-lg">
                    <h2 class="text-xl font-semibold flex items-center">
                        🎉 Listos para Entregar ({{ $readyOrders->count() }})
                    </h2>
                </div>
                <div class="p-4 max-h-96 overflow-y-auto">
                    @forelse($readyOrders as $order)
                        <div class="border border-gray-200 rounded-lg p-4 mb-4">
                            <div class="flex justify-between items-center mb-2">
                                <h3 class="font-semibold text-gray-900">{{ $order->order_number }}</h3>
                                <span class="text-sm text-gray-500">
                                    Listo desde {{ $order->updated_at->locale('es')->isoFormat('HH:mm') }}
                                </span>
                            </div>
                            
                            <p class="text-sm text-gray-600 mb-2">
                                👤 {{ $order->user->name }}
                                @if($order->user->phone)
                                    <br>📱 {{ $order->user->phone }}
                                @endif
                            </p>
                            
                            <div class="mb-3">
                                @foreach($order->orderItems as $item)
                                    <p class="text-sm text-gray-700">
                                        • {{ $item->quantity }}x {{ $item->menuItem->name }}
                                    </p>
                                @endforeach
                            </div>
                            
                            <p class="text-lg font-semibold text-green-600 mb-3">
                                Total: {{ $order->formatted_total }}
                            </p>
                            
                            <form action="{{ route('kitchen.orders.update-status', $order) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="completed">
                                <button type="submit" 
                                        class="w-full bg-gray-600 hover:bg-gray-700 text-white px-3 py-2 rounded text-sm transition duration-150">
                                    ✨ Marcar Entregado
                                </button>
                            </form>
                        </div>
                    @empty
                        <div class="text-center py-8 text-gray-500">
                            <div class="text-4xl mb-2">📦</div>
                            <p>No hay pedidos listos</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Auto-refresh cada 30 segundos -->
<script>
    setTimeout(function() {
        location.reload();
    }, 30000);
</script>
@endsection