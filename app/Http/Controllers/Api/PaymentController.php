<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // Obtener todos los pedidos pagados
    public function getPaidOrders()
    {
        $orders = Order::where('payment_status', 'paid')->get();
        return response()->json($orders);
    }

    // Obtener detalles de un pedido pagado por ID
    public function getPaidOrderDetails($id)
    {
        $order = Order::with('items')->where('id', $id)->where('payment_status', 'paid')->first();

        if (!$order) {
            return response()->json(['message' => 'Pedido no encontrado o no está pagado'], 404);
        }

        return response()->json($order);
    }
}
