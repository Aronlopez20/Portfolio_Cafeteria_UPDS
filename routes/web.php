<?php
// routes/web.php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Auth\GoogleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Cafetería UPDS
|--------------------------------------------------------------------------
*/

// Página principal - redirigir al menú
Route::get('/', function () {
    return redirect()->route('menu.index');
});

// Dashboard - solo para usuarios autenticados
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rutas del menú (públicas)
Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
Route::get('/menu/{menuItem}', [MenuController::class, 'show'])->name('menu.show');

// Rutas de categorías
Route::get('/categoria/{category}', [CategoryController::class, 'show'])->name('categories.show');

// Rutas de carrito y pedidos (requieren autenticación)
Route::middleware(['auth', 'verified'])->group(function () {
    // Carrito
    Route::post('/carrito/agregar/{menuItem}', [OrderController::class, 'addToCart'])->name('cart.add');
    Route::delete('/carrito/eliminar/{menuItem}', [OrderController::class, 'removeFromCart'])->name('cart.remove');
    
    // Pedidos
    Route::get('/pedidos', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/pedidos/crear', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/pedidos', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/pedidos/{order}', [OrderController::class, 'show'])->name('orders.show');
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