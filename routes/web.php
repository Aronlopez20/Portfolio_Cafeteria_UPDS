<?php
// routes/web.php - ACTUALIZADO con roles
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Kitchen\KitchenController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Cafetería UPDS con Sistema de Roles
|--------------------------------------------------------------------------
*/

//
Route::get('/api/orders/{id}/invoice', [OrderController::class, 'invoiceApi']);
//


//
Route::get('/orders/{id}/invoice', [OrderController::class, 'invoice'])->name('orders.invoice');
//

//
use App\Http\Controllers\Api\PaymentController;

Route::get('payments/paid', [PaymentController::class, 'getPaidOrders']);
Route::get('payments/{id}', [PaymentController::class, 'getPaidOrderDetails']);
//

// Página principal - redirigir según rol
Route::get('/', function () {
    if (auth()->check()) {
        $user = auth()->user();
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isKitchen()) {
            return redirect()->route('kitchen.dashboard');
        }
        return redirect()->route('dashboard');
    }
    return redirect()->route('menu.index');
});

// Dashboard principal para estudiantes
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'role:student'])->name('dashboard');

// Rutas del menú (públicas)
Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
Route::get('/menu/{menuItem}', [MenuController::class, 'show'])->name('menu.show');

// Rutas de categorías
Route::get('/categoria/{category}', [CategoryController::class, 'show'])->name('categories.show');

// Rutas de carrito y pedidos (requieren autenticación y rol estudiante)
Route::middleware(['auth', 'verified', 'role:student,admin'])->group(function () {
    // Carrito
    Route::post('/carrito/agregar/{menuItem}', [OrderController::class, 'addToCart'])->name('cart.add');
    Route::delete('/carrito/eliminar/{menuItem}', [OrderController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/orders/confirm', [App\Http\Controllers\OrderController::class, 'confirm'])
    ->name('orders.confirm');


    // Pedidos
    Route::get('/pedidos', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/pedidos/crear', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/pedidos', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/pedidos/{order}', [OrderController::class, 'show'])->name('orders.show');
});

// Rutas de administración
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Gestión de usuarios
    Route::get('/usuarios', [UserController::class, 'index'])->name('users.index');
    Route::get('/usuarios/{user}', [UserController::class, 'show'])->name('users.show');
    Route::post('/usuarios/{user}/asignar-rol', [UserController::class, 'assignRole'])->name('users.assign-role');
    Route::delete('/usuarios/{user}/remover-rol', [UserController::class, 'removeRole'])->name('users.remove-role');

    // Gestión de menú y categorías
    Route::resource('categorias', CategoryController::class);
    Route::resource('menu-items', MenuController::class);

    // Todos los pedidos
    Route::get('/pedidos', [OrderController::class, 'allOrders'])->name('orders.index');
});

// Rutas de cocina
Route::middleware(['auth', 'role:kitchen,admin'])->prefix('kitchen')->name('kitchen.')->group(function () {
    Route::get('/dashboard', [KitchenController::class, 'dashboard'])->name('dashboard');
    Route::patch('/pedidos/{order}/estado', [KitchenController::class, 'updateOrderStatus'])->name('orders.update-status');
    Route::patch('/items/{menuItem}/disponibilidad', [KitchenController::class, 'updateItemAvailability'])->name('items.update-availability');
});

// Rutas de autenticación con Google
Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('auth.google.callback');

// Rutas de perfil (requieren autenticación)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Incluir rutas de autenticación de Breeze
require __DIR__.'/auth.php';
