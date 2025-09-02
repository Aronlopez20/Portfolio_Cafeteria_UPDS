{{-- resources/views/orders/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Mis Pedidos')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">📋 Mis Pedidos</h1>
            <p class="text-xl text-gray-600">Historial de tus pedidos en Cafetería UPDS</p>
        </div>

        @if($orders->isEmpty())
            <!-- Empty State -->
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <div class="text-6xl mb-4">🍽️</div>
                <h2 class="text-2xl font-semibold text-gray-700 mb-2">¡Aún no tienes pedidos!</h2>
                <p class="text-gray-500 mb-6">¿Qué tal si empiezas ordenando algo delicioso?</p>
                <a href="{{ route('menu.index') }}"
                   class="bg-gradient-to-r from-orange-500 to-red-600 hover:from-orange-600 hover:to-red-700 text-white font-bold py-3 px-6 rounded-lg transition duration-150">
                    🍽️ Ver Menú
                </a>
            </div>
        @else
            <!-- Orders List -->
            <div class="space-y-6">
                @foreach($orders as $order)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="px-6 py-4 bg-gradient-to-r from-orange-500 to-red-600 text-white">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h3 class="text-xl font-semibold">🧾 Pedido {{ $order->order_number }}</h3>
                                    <p class="text-orange-100">
                                        📅 {{ $order->created_at->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY [a las] HH:mm') }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-2xl font-bold">{{ $order->formatted_total }}</p>
                                    <div class="flex items-center space-x-2">
                                        @switch($order->status)
                                            @case('pending')
                                                <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-sm">
                                                    ⏳ Pendiente
                                                </span>
                                                @break
                                            @case('confirmed')
                                                <span class="bg-blue-500 text-white px-3 py-1 rounded-full text-sm">
                                                    ✅ Confirmado
                                                </span>
                                                @break
                                            @case('preparing')
                                                <span class="bg-orange-500 text-white px-3 py-1 rounded-full text-sm">
                                                    👨‍🍳 Preparando
                                                </span>
                                                @break
                                            @case('ready')
                                                <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm">
                                                    🎉 Listo
                                                </span>
                                                @break
                                            @case('completed')
                                                <span class="bg-gray-600 text-white px-3 py-1 rounded-full text-sm">
                                                    ✨ Completado
                                                </span>
                                                @break
                                            @case('cancelled')
                                                <span class="bg-red-600 text-white px-3 py-1 rounded-full text-sm">
                                                    ❌ Cancelado
                                                </span>
                                                @break
                                        @endswitch
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="p-6">
                            <!-- Scheduled Time -->
                            @if($order->scheduled_for)
                                <div class="mb-4 p-3 bg-blue-50 rounded-lg">
                                    <p class="text-blue-800 font-medium">
                                        ⏰ Programado para: {{ $order->scheduled_for->locale('es')->isoFormat('dddd, D [de] MMMM [a las] HH:mm') }}
                                    </p>
                                </div>
                            @endif

                            <!-- Special Notes -->
                            @if($order->special_notes)
                                <div class="mb-4 p-3 bg-yellow-50 rounded-lg">
                                    <p class="text-yellow-800">
                                        <span class="font-medium">📝 Notas especiales:</span> {{ $order->special_notes }}
                                    </p>
                                </div>
                            @endif

                            <!-- Order Items -->
                            <div class="space-y-3">
                                @foreach($order->orderItems as $orderItem)
                                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                        <div class="flex-1">
                                            <h4 class="font-medium text-gray-900">{{ $orderItem->menuItem->name }}</h4>
                                            <p class="text-sm text-gray-600">
                                                Cantidad: {{ $orderItem->quantity }} × Bs. {{ number_format($orderItem->unit_price, 2) }}
                                            </p>
                                            @if($orderItem->customizations)
                                                <p class="text-xs text-orange-600">
                                                    ✨ {{ $orderItem->customizations }}
                                                </p>
                                            @endif
                                        </div>
                                        <div class="text-right">
                                            <p class="font-medium">Bs. {{ number_format($orderItem->total_price, 2) }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Order Actions -->
                            <div class="mt-6 flex justify-end space-x-3">
                                <a href="{{ route('orders.show', $order) }}"
                                   class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-2 rounded-md text-sm font-medium transition duration-150">
                                    👁️ Ver Detalles
                                </a>
                                <a href="{{ route('orders.invoice', $order->id) }}">🧾 Ver Factura</a>
                                @if($order->status === 'pending' && !$order->scheduled_for)
                                    <button class="bg-red-100 hover:bg-red-200 text-red-800 px-4 py-2 rounded-md text-sm font-medium transition duration-150">
                                        ❌ Cancelar
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
