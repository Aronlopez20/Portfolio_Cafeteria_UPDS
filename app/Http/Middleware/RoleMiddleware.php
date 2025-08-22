<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!auth()->check()) {
            return redirect('login');
        }

        $user = auth()->user();
        
        if (!$user->hasAnyRole($roles)) {
            abort(403, '❌ No tienes permisos para acceder a esta sección');
        }

        return $next($request);
    }
}
