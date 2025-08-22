<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\MenuItem;
use App\Models\Category;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index()
    {
        $stats = [
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'total_users' => User::students()->count(),
            'total_menu_items' => MenuItem::count(),
            'active_menu_items' => MenuItem::where('is_available', true)->count(),
            'total_revenue' => Order::where('payment_status', 'paid')->sum('total_amount'),
        ];

        $recent_orders = Order::with(['user', 'orderItems.menuItem'])
                             ->latest()
                             ->take(10)
                             ->get();

        $popular_items = MenuItem::withCount(['orderItems' => function($query) {
                                    $query->whereHas('order', function($q) {
                                        $q->where('status', '!=', 'cancelled');
                                    });
                                }])
                                ->orderBy('order_items_count', 'desc')
                                ->take(5)
                                ->get();

        return view('admin.dashboard', compact('stats', 'recent_orders', 'popular_items'));
    }
}