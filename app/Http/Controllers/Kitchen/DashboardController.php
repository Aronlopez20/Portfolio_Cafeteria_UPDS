<?php
namespace App\Http\Controllers\Kitchen;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class KitchenController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:kitchen,admin']);
    }

    public function dashboard()
    {
        $pendingOrders = Order::whereIn('status', ['pending', 'confirmed'])
                             ->with(['user', 'orderItems.menuItem'])
                             ->orderBy('scheduled_for')
                             ->orderBy('created_at')
                             ->get();

        $preparingOrders = Order::where('status', 'preparing')
                               ->with(['user', 'orderItems.menuItem'])
                               ->orderBy('created_at')
                               ->get();

        $readyOrders = Order::where('status', 'ready')
                           ->with(['user', 'orderItems.menuItem'])
                           ->orderBy('updated_at')
                           ->get();

        $stats = [
            'pending_count' => $pendingOrders->count(),
            'preparing_count' => $preparingOrders->count(),
            'ready_count' => $readyOrders->count(),
            'avg_preparation_time' => $this->getAveragePreparationTime(),
        ];

        return view('kitchen.dashboard', compact(
            'pendingOrders', 
            'preparingOrders', 
            'readyOrders', 
            'stats'
        ));
    }

    public function updateOrderStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:confirmed,preparing,ready,completed'
        ]);

        $oldStatus = $order->status;
        $order->update(['status' => $request->status]);

        // Log del cambio de estado
        activity()
            ->performedOn($order)
            ->by(auth()->user())
            ->withProperties([
                'old_status' => $oldStatus,
                'new_status' => $request->status,
            ])
            ->log("Order status changed from {$oldStatus} to {$request->status}");

        $statusMessages = [
            'confirmed' => '✅ Pedido confirmado',
            'preparing' => '👨‍🍳 Pedido en preparación', 
            'ready' => '🎉 Pedido listo para recoger',
            'completed' => '✨ Pedido completado',
        ];

        return back()->with('success', $statusMessages[$request->status]);
    }

    public function updateItemAvailability(Request $request, MenuItem $menuItem)
    {
        $request->validate([
            'available_quantity' => 'required|integer|min:0',
            'is_available' => 'boolean'
        ]);

        $menuItem->update([
            'available_quantity' => $request->available_quantity,
            'is_available' => $request->is_available ?? ($request->available_quantity > 0),
        ]);

        return back()->with('success', "📦 Disponibilidad de {$menuItem->name} actualizada");
    }

    private function getAveragePreparationTime()
    {
        $completedOrders = Order::where('status', 'completed')
                               ->whereDate('created_at', today())
                               ->get();

        if ($completedOrders->isEmpty()) {
            return 0;
        }

        $totalTime = 0;
        $count = 0;

        foreach ($completedOrders as $order) {
            $preparingTime = $order->updated_at->diffInMinutes($order->created_at);
            $totalTime += $preparingTime;
            $count++;
        }

        return $count > 0 ? round($totalTime / $count) : 0;
    }
}