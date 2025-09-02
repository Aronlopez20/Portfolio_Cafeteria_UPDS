@extends('layouts.app')
@section('content')
{{-- ------------------------------------------------
  VISTA DE FACTURA EN HTML
  Muestra la factura al usuario en el navegador
  Incluye  formato y total
  Nota: Esta vista es diferente a la API JSON
------------------------------------------------ --}}
@section('content')
<h2>🧾 Factura Pedido {{ $order->order_number }}</h2>

<!-- Si hay fecha, mostrarla; si no, mostrar "No programado" -->
<p>📅
    {{ $order->scheduled_for ? $order->scheduled_for->format('l, d \d\e F \d\e Y \a \l\a\s H:i') : 'No programado' }}
</p>

<p>💳 Estado del pago: {{ ucfirst($order->payment_status) }}</p>
<p>Usuario: {{ $order->user->name }}</p>

<table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%;">
    <thead>
        <tr>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio Unitario</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($order->orderItems as $item)
        <tr>
            <td>{{ $item->menuItem->name }} 🍳</td>
            <td>{{ $item->quantity }}</td>
            <td>Bs. {{ number_format($item->unit_price, 2) }}</td>
            <td>Bs. {{ number_format($item->total_price, 2) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<h3>Total: Bs. {{ number_format($order->total_amount, 2) }}</h3>
@endsection
