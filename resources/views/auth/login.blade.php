{{-- resources/views/auth/login.blade.php --}}
<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-orange-400 via-red-500 to-pink-500">
        <div class="bg-white p-8 rounded-xl shadow-2xl w-full max-w-md">
            <!-- Logo -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">☕ Cafetería UPDS</h1>
                <p class="text-gray-600">🎓 Tu cafetería universitaria favorita</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-4">
                    <x-input-label for="email" :value="'📧 Email'" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <x-input-label for="password" :value="'🔒 Contraseña'" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="block mb-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-orange-600 shadow-sm focus:ring-orange-500" name="remember">
                        <span class="ml-2 text-sm text-gray-600">🧠 Recordarme</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <div class="mb-6">
                    <x-primary-button class="w-full justify-center bg-gradient-to-r from-orange-500 to-red-600 hover:from-orange-600 hover:to-red-700">
                        🚀 Iniciar Sesión
                    </x-primary-button>
                </div>

                <!-- Google Login -->
                <div class="mb-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">O continúa con</span>
                        </div>
                    </div>
                    
                    <a href="{{ route('auth.google') }}" 
                       class="mt-4 w-full inline-flex justify-center items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                        <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google" class="w-5 h-5 mr-2">
                        🌟 Iniciar con Google
                    </a>
                </div>

                <!-- Links -->
                <div class="text-center">
                    @if (Route::has('password.request'))
                        <a class="text-sm text-orange-600 hover:text-orange-900" href="{{ route('password.request') }}">
                            🤔 ¿Olvidaste tu contraseña?
                        </a>
                    @endif

                    <div class="mt-4">
                        <span class="text-sm text-gray-600">¿No tienes cuenta? </span>
                        <a href="{{ route('register') }}" class="text-sm text-orange-600 hover:text-orange-900 font-medium">
                            📝 Regístrate aquí
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>