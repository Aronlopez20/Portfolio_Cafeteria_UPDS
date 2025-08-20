{{-- resources/views/auth/register.blade.php --}}
<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-orange-400 via-red-500 to-pink-500">
        <div class="bg-white p-8 rounded-xl shadow-2xl w-full max-w-md">
            <!-- Logo -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">☕ Cafetería UPDS</h1>
                <p class="text-gray-600">🎉 ¡Únete a nuestra comunidad!</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="mb-4">
                    <x-input-label for="name" :value="'👤 Nombre Completo'" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div class="mb-4">
                    <x-input-label for="email" :value="'📧 Email'" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    <p class="text-xs text-gray-500 mt-1">💌 Te enviaremos un email de verificación</p>
                </div>

                <!-- Student Code -->
                <div class="mb-4">
                    <x-input-label for="student_code" :value="'🎓 Código de Estudiante (Opcional)'" />
                    <x-text-input id="student_code" class="block mt-1 w-full" type="text" name="student_code" :value="old('student_code')" autocomplete="student_code" />
                    <x-input-error :messages="$errors->get('student_code')" class="mt-2" />
                </div>

                <!-- Phone -->
                <div class="mb-4">
                    <x-input-label for="phone" :value="'📱 Teléfono (Opcional)'" />
                    <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" autocomplete="phone" />
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <x-input-label for="password" :value="'🔒 Contraseña'" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mb-6">
                    <x-input-label for="password_confirmation" :value="'🔒 Confirmar Contraseña'" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <!-- Submit Button -->
                <div class="mb-6">
                    <x-primary-button class="w-full justify-center bg-gradient-to-r from-orange-500 to-red-600 hover:from-orange-600 hover:to-red-700">
                        🎉 Crear Cuenta
                    </x-primary-button>
                </div>

                <!-- Google Register -->
                <div class="mb-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">O regístrate con</span>
                        </div>
                    </div>
                    
                    <a href="{{ route('auth.google') }}" 
                       class="mt-4 w-full inline-flex justify-center items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                        <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google" class="w-5 h-5 mr-2">
                        🌟 Registrarse con Google
                    </a>
                </div>

                <!-- Link to Login -->
                <div class="text-center">
                    <span class="text-sm text-gray-600">¿Ya tienes cuenta? </span>
                    <a href="{{ route('login') }}" class="text-sm text-orange-600 hover:text-orange-900 font-medium">
                        🔑 Inicia sesión aquí
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>