<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            $user = User::where('google_id', $googleUser->id)
                       ->orWhere('email', $googleUser->email)
                       ->first();

            if ($user) {
                // Usuario existente - actualizar datos de Google
                $user->update([
                    'google_id' => $googleUser->id,
                    'avatar' => $googleUser->avatar,
                    'email_verified_at' => now(),
                    'last_login_at' => now(),
                ]);
            } else {
                // Crear nuevo usuario
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'avatar' => $googleUser->avatar,
                    'password' => Hash::make(Str::random(24)),
                    'email_verified_at' => now(),
                    'status' => 'active',
                    'last_login_at' => now(),
                ]);

                // Asignar rol de estudiante por defecto
                $studentRole = Role::where('name', Role::STUDENT)->first();
                if ($studentRole) {
                    $user->assignRole($studentRole);
                }
            }

            Auth::login($user, true);
            
            // Redirigir según el rol
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard')->with('success', '🎉 ¡Bienvenido Administrador!');
            } elseif ($user->isKitchen()) {
                return redirect()->route('kitchen.dashboard')->with('success', '🎉 ¡Bienvenido al área de cocina!');
            } else {
                return redirect()->route('dashboard')->with('success', '🎉 ¡Bienvenido a Cafetería UPDS!');
            }
            
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', '❌ Error al iniciar sesión con Google');
        }
    }
}