@extends('layouts.app')

@section('title', 'Confirmar o Cancelar Pedido')

@section('content')
<div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-8 shadow sm:rounded-lg text-center">
            <h1 class="text-2xl font-bold text-gray-900 mb-6"> ¿Desea confirmar tu pedido?</h1>

            <!-- Mostrar QR de pago -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-2"> Escanea este QR para pagar</h2>
                <img src="{{ asset('imagenes/qr-pago.jpg') }}" alt="QR de pago" class="mx-auto w-64 h-64 border rounded shadow">
                <p class="mt-2 text-sm text-gray-500">Escanea con tu app bancaria para realizar el pago</p>
            </div>

            <!-- Formulario de confirmación con NIT, nombre y comprobante -->
            <form method="POST" action="{{ route('orders.store') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf

               <!-- NIT (solo números) -->
                 <p class="mt-2 text-sm text-gray-500">Nit</p>
<input type="text" name="nit" 
       pattern="[0-9]+" 
       title="El NIT solo puede contener números" 
       required
       class="w-full border rounded p-2">

<!-- Nombre (solo letras y espacios) -->
  <p class="mt-2 text-sm text-gray-500">Nombre</p>
<input type="text" name="nombre" 
       pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ ]+" 
       title="El nombre solo puede contener letras y espacios" 
       required
       class="w-full border rounded p-2">


                <!-- Subir comprobante de pago -->
                <div>
                    <label for="comprobante" class="block text-sm font-medium text-gray-700 mb-1">📤 Subir comprobante de pago (imagen)</label>
                    <input type="file" id="comprobante" name="comprobante" accept="image/*"
                           class="w-full text-sm text-gray-700">
                    @error('comprobante')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Botones -->
                <div class="flex justify-center space-x-4">
                    <!-- Cancelar -->
                    <a href="{{ route('menu.index') }}" 
                       class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-3 px-6 rounded">
                        ❌ Cancelar Pedido
                    </a>

                    <!-- Confirmar pedido -->
                    <button type="submit" 
                            class="bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded">
                        ✅ Confirmar Pedido
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
