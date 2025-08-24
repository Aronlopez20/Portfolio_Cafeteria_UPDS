{{-- resources/views/orders/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Crear Pedido')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-8">
                <!-- Header -->
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">🛒 Confirmar Pedido</h1>
                    <p class="text-gray-600">Revisa tu pedo antes de confirmar</p>
                </div>

                <!-- Order Items -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">📋 Tu Pedido</h2>
                    
                    @foreach($items as $item)
                        <div class="flex justify-between items-center py-4 border-b border-gray-200">
                            <div class="flex-1">
                                <h3 class="font-medium text-gray-900">{{ $item['item']->name }}</h3>
                                <p class="text-sm text-gray-600">{{ $item['item']->description }}</p>
                                <div class="flex items-center mt-2">
                                    <span class="text-sm text-orange-600 font-medium">
                                        {{ $item['item']->formatted_price }} × {{ $item['quantity'] }}
                                    </span>
                                    <span class="ml-4 text-xs text-gray-500">
                                        ⏱️ ~{{ $item['item']->preparation_time }} min
                                    </span>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-gray-900">
                                    Bs. {{ number_format($item['subtotal'], 2) }}
                                </p>
                                <form action="{{ route('cart.remove', $item['item']) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm">
                                        🗑️ Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach

                    <!-- Total -->
                    <div class="py-4 border-t-2 border-gray-300">
                        <div class="flex justify-between items-center">
                            <span class="text-xl font-semibold text-gray-900">💰 Total:</span>
                            <span class="text-2xl font-bold text-orange-600">
                                Bs. {{ number_format($total, 2) }}
                            </span>
                        </div>
                    </div>
                </div>

              <!-- Order Form -->
<form method="POST" action="{{ route('orders.confirm') }}" class="space-y-6">
    @csrf
    
    <!-- Special Notes -->
    <div>
        <label for="special_notes" class="block text-sm font-medium text-gray-700 mb-2">
            📝 Notas Especiales (Opcional)
        </label>
        <textarea id="special_notes" name="special_notes" rows="3" 
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-orange-500 focus:border-orange-500"
                  placeholder="Ej: Sin cebolla, extra queso, etc.">{{ old('special_notes') }}</textarea>
        @error('special_notes')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Scheduled Time -->
    <div>
        <label for="scheduled_for" class="block text-sm font-medium text-gray-700 mb-2">
            ⏰ Programar para más tarde (Opcional)
        </label>
        <input type="datetime-local" id="scheduled_for" name="scheduled_for"
               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-orange-500 focus:border-orange-500"
               min="{{ now()->addMinutes(30)->format('Y-m-d\TH:i') }}"
               max="{{ now()->addHours(8)->format('Y-m-d\TH:i') }}"
               value="{{ old('scheduled_for') }}">
        <p class="mt-1 text-xs text-gray-500">
            💡 Si no seleccionas hora, prepararemos tu pedido inmediatamente
        </p>
        @error('scheduled_for')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Action Buttons -->
    <div class="flex space-x-4">
        <a href="{{ route('menu.index') }}" 
           class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-3 px-4 rounded text-center transition duration-150">
            ⬅️ Seguir Comprando
        </a>
        <button type="submit" 
                class="flex-1 bg-gradient-to-r from-orange-500 to-red-600 hover:from-orange-600 hover:to-red-700 text-white font-bold py-3 px-4 rounded transition duration-150">
            🚀 Pagar Pedido
        </button>
    </div>
</form>

            </div>
        </div>
    </div>
</div>
@endsection