<?php
// app/Http/Controllers/OrderController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\MenuItem;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $orders = Auth::user()->orders()->latest()->with('orderItems.menuItem')->get();
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $cartItems = session('cart', []);
        if (empty($cartItems)) {
            return redirect()->route('menu.index')->with('error', '🛒 Tu carrito está vacío');
        }

        $total = 0;
        $items = [];
        
        foreach ($cartItems as $itemId => $quantity) {
            $menuItem = MenuItem::find($itemId);
            if ($menuItem && $menuItem->is_available) {
                $items[] = [
                    'item' => $menuItem,
                    'quantity' => $quantity,
                    'subtotal' => $menuItem->price * $quantity
                ];
                $total += $menuItem->price * $quantity;
            }
        }

        return view('orders.create', compact('items', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'special_notes' => 'nullable|string|max:500',
            'scheduled_for' => 'nullable|date|after:now'
        ]);

        $cartItems = session('cart', []);
        
        if (empty($cartItems)) {
            return redirect()->route('menu.index')->with('error', '🛒 Tu carrito está vacío');
        }

        DB::transaction(function () use ($request, $cartItems) {
            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'user_id' => Auth::id(),
                'total_amount' => 0,
                'status' => 'pending',
                'special_notes' => $request->special_notes,
                'scheduled_for' => $request->scheduled_for,
            ]);

            $total = 0;
            
            foreach ($cartItems as $itemId => $quantity) {
                $menuItem = MenuItem::find($itemId);
                if ($menuItem && $menuItem->is_available && $menuItem->available_quantity >= $quantity) {
                    $subtotal = $menuItem->price * $quantity;
                    
                    OrderItem::create([
                        'order_id' => $order->id,
                        'menu_item_id' => $menuItem->id,
                        'quantity' => $quantity,
                        'unit_price' => $menuItem->price,
                        'total_price' => $subtotal,
                    ]);

                    // Actualizar cantidad disponible
                    $menuItem->decrement('available_quantity', $quantity);
                    $total += $subtotal;
                }
            }

            $order->update(['total_amount' => $total]);
            session()->forget('cart');
        });

        return redirect()->route('orders.index')->with('success', '🎉 ¡Pedido creado exitosamente!');
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order);
        return view('orders.show', compact('order'));
    }

    public function addToCart(Request $request, MenuItem $menuItem)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:10'
        ]);

        if (!$menuItem->is_available || $menuItem->available_quantity < $request->quantity) {
            return back()->with('error', '❌ Producto no disponible en la cantidad solicitada');
        }

        $cart = session('cart', []);
        $currentQuantity = $cart[$menuItem->id] ?? 0;
        $newQuantity = $currentQuantity + $request->quantity;

        if ($newQuantity > $menuItem->available_quantity) {
            return back()->with('error', '❌ No hay suficiente stock disponible');
        }

        $cart[$menuItem->id] = $newQuantity;
        session(['cart' => $cart]);

        return back()->with('success', "🛒 {$menuItem->name} agregado al carrito");
    }

    public function removeFromCart(MenuItem $menuItem)
    {
        $cart = session('cart', []);
        unset($cart[$menuItem->id]);
        session(['cart' => $cart]);

        return back()->with('success', '🗑️ Producto eliminado del carrito');
    }
}