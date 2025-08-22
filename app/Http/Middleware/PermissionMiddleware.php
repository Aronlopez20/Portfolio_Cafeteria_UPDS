<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PermissionMiddleware
{
    public function handle(Request $request, Closure $next, $permission)
    {
        if (!auth()->check()) {
            return redirect('login');
        }

        if (!auth()->user()->hasPermission($permission)) {
            abort(403, '❌ No tienes permisos para realizar esta acción');
        }

        return $next($request);
    }
}
