{{-- resources/views/auth/verify-email.blade.php --}}
<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-orange-400 via-red-500 to-pink-500">
        <div class="bg-white p-8 rounded-xl shadow-2xl w-full max-w-md text-center">
            <!-- Logo -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">📧 Verifica tu Email</h1>
                <p class="text-gray-600">☕ Cafetería UPDS</p>
            </div>

            <div class="mb-6 text-center">
                <div class="text-6xl mb-4">📬</div>
                <p class="text-sm text-gray-600">
                    ¡Gracias por registrarte! 🎉 Antes de comenzar, ¿podrías verificar tu dirección de email haciendo clic en el enlace que acabamos de enviarte? Si no recibiste el email, con gusto te enviaremos otro.
                </p>
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 font-medium text-sm text-green-600 bg-green-100 p-3 rounded">
                    ✅ Se ha enviado un nuevo enlace de verificación a tu dirección de email.
                </div>
            @endif

            <div class="mt-4 flex flex-col space-y-4">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="w-full bg-gradient-to-r from-orange-500 to-red-600 hover:from-orange-600 hover:to-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        📤 Reenviar Email de Verificación
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        🚪 Cerrar Sesión
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>