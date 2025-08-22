<?php

namespace App\Http\Controllers\Kitchen;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KitchenController extends Controller
{
    /**
     * Display the kitchen dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        // Obtener pedidos por estado
        $pendingOrders = Order::with(['user', 'orderItems.menuItem'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'asc')
            ->get();

        $preparingOrders = Order::with(['user', 'orderItems.menuItem'])
            ->where('status', 'confirmed')
            ->orderBy('created_at', 'asc')
            ->get();

        $readyOrders = Order::with(['user', 'orderItems.menuItem'])
            ->where('status', 'ready')
            ->orderBy('updated_at', 'desc')
            ->get();

        // Calcular estadísticas
        $stats = [
            'pending_count' => $pendingOrders->count(),
            'preparing_count' => $preparingOrders->count(),
            'ready_count' => $readyOrders->count(),
            'avg_preparation_time' => $this->calculateAveragePreparationTime()
        ];

        return view('kitchen.dashboard', compact(
            'pendingOrders',
            'preparingOrders',
            'readyOrders',
            'stats'
        ));
    }

    /**
     * Update order status
     *
     * @param Request $request
     * @param Order $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateOrderStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:confirmed,ready,completed'
        ]);

        $oldStatus = $order->status;
        $newStatus = $request->status;

        // Actualizar el estado
        $order->update([
            'status' => $newStatus,
            'updated_at' => now()
        ]);

        // Mensajes de éxito según el estado
        $messages = [
            'confirmed' => "Pedido {$order->order_number} confirmado y en preparación",
            'ready' => "Pedido {$order->order_number} listo para entregar",
            'completed' => "Pedido {$order->order_number} marcado como entregado"
        ];

        return redirect()->route('kitchen.dashboard')
            ->with('success', $messages[$newStatus]);
    }

    /**
     * Update menu item availability
     *
     * @param Request $request
     * @param MenuItem $menuItem
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateItemAvailability(Request $request, $menuItem)
    {
        $request->validate([
            'is_available' => 'required|boolean'
        ]);

        $menuItem = \App\Models\MenuItem::findOrFail($menuItem);
        
        $menuItem->update([
            'is_available' => $request->is_available
        ]);

        $status = $request->is_available ? 'disponible' : 'no disponible';
        
        return redirect()->route('kitchen.dashboard')
            ->with('success', "Item {$menuItem->name} marcado como {$status}");
    }

    /**
     * Calculate average preparation time
     *
     * @return string
     */
    private function calculateAveragePreparationTime()
    {
        $completedOrders = Order::where('status', 'completed')
            ->whereDate('updated_at', today())
            ->get();

        if ($completedOrders->isEmpty()) {
            return '--';
        }

        $totalMinutes = 0;
        $count = 0;

        foreach ($completedOrders as $order) {
            // Calcular tiempo desde creación hasta completado
            $minutes = $order->created_at->diffInMinutes($order->updated_at);
            if ($minutes > 0 && $minutes < 120) { // Filtrar tiempos irreales
                $totalMinutes += $minutes;
                $count++;
            }
        }

        return $count > 0 ? round($totalMinutes / $count) : '--';
    }
}