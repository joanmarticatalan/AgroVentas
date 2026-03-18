<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión - AgroVentas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-agro-bg text-agro-text min-h-screen flex flex-col text-lg">

    <header class="bg-agro-primary shadow-md">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

            <a href="/" class="text-white text-2xl font-bold tracking-wide">AgroVentas</a>

            <nav class="hidden md:flex items-center gap-8">
                <a href="/" class="text-white text-lg hover:text-agro-accent transition-colors">Inicio</a>
                <a href="/products" class="text-white text-lg hover:text-agro-accent transition-colors">Productos</a>
            </nav>

            <div class="flex items-center gap-4">
                <a href="/carro" class="text-white text-lg hover:text-agro-accent transition-colors">🛒 Carrito</a>
                <a href="/login" class="text-white text-lg hover:text-agro-accent transition-colors">Iniciar sesión</a>
                <a href="/register" class="bg-agro-accent hover:bg-orange-600 text-white text-lg font-semibold px-5 py-2 rounded-xl transition-colors">Registrarse</a>
            </div>

        </div>
    </header>

    <main class="flex-grow flex items-center justify-center py-16">
        <div class="bg-white rounded-2xl shadow-lg p-10 w-full max-w-md">

            <h1 class="text-3xl font-bold text-agro-primary text-center mb-8">Iniciar sesión</h1>

            {{-- Errores --}}
            @if ($errors->any())
                <div class="bg-red-100 text-red-700 rounded-lg px-5 py-4 mb-6">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="flex flex-col gap-5">
                @csrf

                <div class="flex flex-col gap-2">
                    <label for="email" class="text-agro-text font-semibold">Correo electrónico</label>
                    <input type="email" id="email" name="email" placeholder="ejemplo@correo.com"
                           value="{{ old('email') }}" required
                           class="border border-gray-300 rounded-lg px-4 py-3 text-lg focus:outline-none focus:border-agro-primary">
                </div>

                <div class="flex flex-col gap-2">
                    <label for="password" class="text-agro-text font-semibold">Contraseña</label>
                    <input type="password" id="password" name="password" placeholder="Tu contraseña"
                           required
                           class="border border-gray-300 rounded-lg px-4 py-3 text-lg focus:outline-none focus:border-agro-primary">
                </div>

                <button type="submit"
                        class="bg-agro-primary hover:bg-agro-secondary text-white text-xl font-semibold py-4 rounded-xl transition-colors mt-2">
                    Entrar
                </button>

                <p class="text-center text-agro-muted">
                    ¿No tienes cuenta?
                    <a href="/register" class="text-agro-primary font-semibold hover:text-agro-secondary transition-colors">Créala aquí</a>
                </p>

            </form>
        </div>
    </main>

    <footer class="bg-agro-primary text-white mt-auto">
        <div class="max-w-7xl mx-auto px-6 py-10 grid grid-cols-1 md:grid-cols-3 gap-8">

            <div class="flex flex-col gap-3">
                <span class="text-2xl font-bold">AgroVentas</span>
                <p class="text-green-200 text-base">Del huerto a casa.</p>
            </div>

            <div class="flex flex-col gap-2">
                <span class="text-lg font-semibold text-agro-accent">Información</span>
                <a href="mailto:contacto@agroventas.es" class="text-green-200 hover:text-white transition-colors">contacto@agroventas.es</a>
                <a href="/aviso-legal" class="text-green-200 hover:text-white transition-colors">Aviso legal</a>
                <a href="/privacidad" class="text-green-200 hover:text-white transition-colors">Política de privacidad</a>
            </div>

            <div class="flex flex-col gap-2">
                <span class="text-lg font-semibold text-agro-accent">Síguenos</span>
                <a href="https://linkedin.com" target="_blank" class="text-green-200 hover:text-white transition-colors">LinkedIn</a>
                <a href="https://github.com" target="_blank" class="text-green-200 hover:text-white transition-colors">GitHub</a>
            </div>

        </div>
        <div class="border-t border-green-700 text-center py-4 text-green-300 text-sm">
            © {{ date('Y') }} AgroVentas. Todos los derechos reservados.
        </div>
    </footer>

</body>
</html>