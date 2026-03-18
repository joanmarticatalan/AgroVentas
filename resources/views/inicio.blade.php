<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AgroVentas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-agro-bg text-agro-text min-h-screen flex flex-col text-lg">

    <header class="bg-agro-primary shadow-md">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

            <a href="/" class="flex items-center gap-3">
                <span class="text-white text-2xl font-bold tracking-wide">AgroVentas</span>
            </a>

            <nav class="hidden md:flex items-center gap-8">
                <a href="/" class="text-white text-lg hover:text-agro-accent transition-colors">Inicio</a>
                <a href="/products" class="text-white text-lg hover:text-agro-accent transition-colors">Productos</a>
                @auth
                    <a href="{{ route('pedidos.usuario') }}" class="text-white text-lg hover:text-agro-accent transition-colors">Mis pedidos</a>
                    <a href="{{ route('mis.productos') }}" class="text-white text-lg hover:text-agro-accent transition-colors">Mis productos</a>
                @endauth
            </nav>

            <div class="flex items-center gap-4">
                <a href="/carro" class="text-white text-lg hover:text-agro-accent transition-colors">🛒 Carrito</a>
                @auth
                    <a href="{{ route('perfil.editar') }}" class="text-white text-lg hover:text-agro-accent transition-colors">Mi perfil</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-agro-accent hover:bg-orange-600 text-white text-lg font-semibold px-5 py-2 rounded-lg transition-colors">
                            Salir
                        </button>
                    </form>
                @else
                    <a href="/login" class="text-white text-lg hover:text-agro-accent transition-colors">Iniciar sesión</a>
                    <a href="/register" class="bg-agro-accent hover:bg-orange-600 text-white text-lg font-semibold px-5 py-2 rounded-xl transition-colors">
                        Registrarse
                    </a>
                @endauth
            </div>

        </div>
    </header>

    <main class="flex-grow">
        <section class="bg-agro-bg py-20 text-center">
            <div class="max-w-3xl mx-auto px-6">
                <h1 class="text-5xl font-bold text-agro-primary mb-4">AgroVentas</h1>
                <h2 class="text-2xl text-agro-muted mb-12">Del huerto a casa</h2>

                <h3 class="text-2xl font-semibold text-agro-text mb-8">¿Qué vas a hacer hoy?</h3>

                <div class="flex flex-col sm:flex-row gap-6 justify-center">
                    <a href="/products"
                       class="bg-agro-primary hover:bg-agro-secondary text-white text-xl font-semibold px-10 py-5 rounded-xl transition-colors">
                        🛒 Comprar
                    </a>
                    <a href="/products"
                       class="bg-agro-accent hover:bg-orange-600 text-white text-xl font-semibold px-10 py-5 rounded-xl transition-colors">
                        📦 Vender
                    </a>
                </div>
            </div>
        </section>
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