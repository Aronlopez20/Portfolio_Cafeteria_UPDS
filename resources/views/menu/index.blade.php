{{-- resources/views/menu/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Menú del Día')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">
                🍽️ Menú del Día
            </h1>
            <p class="text-xl text-gray-600">
                📅 {{ now()->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}
            </p>
            <p class="text-lg text-orange-600 mt-2">
                🕐 Horario de atención: 7:00 AM - 6:00 PM
            </p>
        </div>

        <!-- Categories -->
        @foreach($categories as $category)
            @if($category->menuItems->count() > 0)
                <div class="mb-12">
                    <!-- Category Header -->
                    <div class="bg-gradient-to-r from-orange-500 to-red-500 text-white rounded-lg p-6 mb-6">
                        <h2 class="text-2xl font-bold flex items-center">
                            {{ $category->icon }} {{ $category->name }}
                        </h2>
                        <p class="text-orange-100 mt-2">{{ $category->description }}</p>
                    </div>

                    <!-- Menu Items Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($category->menuItems as $item)
                            <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition duration-300 overflow-hidden">
                                <!-- Item Image Placeholder -->
                                <div class="bg-gradient-to-br from-orange-400 to-red-500 h-48 flex items-center justify-center">
                                    <span class="text-6xl">🍽️</span>
                                </div>
                                
                                <div class="p-6">
                                    <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $item->name }}</h3>
                                    <p class="text-gray-600 mb-4">{{ $item->description }}</p>
                                    
                                    <!-- Price and Info -->
                                    <div class="flex justify-between items-center mb-4">
                                        <span class="text-2xl font-bold text-orange-600">{{ $item->formatted_price }}</span>
                                        <div class="flex space-x-2 text-sm">
                                            @if($item->is_vegetarian)
                                                <span class="text-green-600">🌱 Vegetariano</span>
                                            @endif
                                            @if($item->is_vegan)
                                                <span class="text-green-600">🌿 Vegano</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Availability and Time -->
                                    <div class="mb-4 text-sm text-gray-500">
                                        <p>⏱️ Tiempo de preparación: {{ $item->preparation_time }} min</p>
                                        <p>📦 Disponible: {{ $item->available_quantity }} unidades</p>
                                    </div>

                                    <!-- Add to Cart Form -->
                                    @auth
                                        @if($item->is_available && $item->available_quantity > 0)
                                            <form action="{{ route('cart.add', $item) }}" method="POST" class="flex space-x-2">
                                                @csrf
                                                <input type="number" name="quantity" min="1" max="{{ min($item->available_quantity, 10) }}" 
                                                       value="1" class="flex-1 rounded-md border-gray-300 text-center">
                                                <button type="submit" 
                                                        class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-md font-medium transition duration-150">
                                                    🛒 Agregar
                                                </button>
                                            </form>
                                        @else
                                            <button disabled class="w-full bg-gray-300 text-gray-500 px-4 py-2 rounded-md">
                                                😢 Agotado
                                            </button>
                                        @endif
                                    @else
                                        <div class="text-center">
                                            <a href="{{ route('login') }}" 
                                               class="text-orange-600 hover:text-orange-800 font-medium">
                                                🔑 Inicia sesión para ordenar
                                            </a>
                                        </div>
                                    @endauth
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach

        @if($categories->isEmpty() || $categories->every(fn($cat) => $cat->menuItems->isEmpty()))
            <div class="text-center py-12">
                <p class="text-2xl text-gray-500">😴 No hay menú disponible en este momento</p>
                <p class="text-gray-400 mt-2">Vuelve más tarde para ver nuestras deliciosas opciones</p>
            </div>
        @endif
    </div>
</div>
@endsection
