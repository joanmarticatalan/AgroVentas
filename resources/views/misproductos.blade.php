<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis productos - AgroVentas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-agro-bg text-agro-text min-h-screen flex flex-col text-lg">

    <header class="bg-agro-primary shadow-md">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

            <a href="/" class="text-white text-2xl font-bold tracking-wide">AgroVentas</a>

            <nav class="hidden md:flex items-center gap-8">
                <a href="/" class="text-white text-lg hover:text-agro-accent transition-colors">Inicio</a>
                <a href="{{ route('todos.productos') }}" class="text-white text-lg hover:text-agro-accent transition-colors">Productos</a>
                @auth
                    <a href="{{ route('pedidos.usuario') }}" class="text-white text-lg hover:text-agro-accent transition-colors">Mis pedidos</a>
                    @if(auth()->user()->tipoCliente === 'vendedor' || auth()->user()->tipoCliente === 'compraventa')
                        <a href="{{ route('mis.productos') }}" class="text-white text-lg hover:text-agro-accent transition-colors">Mis productos</a>
                        <a href="{{ route('pedidos.vendedor') }}" class="text-white text-lg hover:text-agro-accent transition-colors">Pedidos</a>
                        <a href="{{ route('pg.anadir.producto') }}" class="text-white text-lg hover:text-agro-accent transition-colors">Añadir producto</a>
                    @endif
                    @if(auth()->user()->tipoCliente === 'admin')
                        <a href="{{ route('users.index') }}" class="text-white text-lg hover:text-agro-accent transition-colors">Gestión usuarios</a>
                    @endif
                @endauth
            </nav>

            <div class="flex items-center gap-4">
                <a href="{{ route('carrito.all') }}" class="text-white text-lg hover:text-agro-accent transition-colors">🛒 Carrito</a>
                @auth
                    <a href="{{ route('perfil.editar') }}" class="text-white text-lg hover:text-agro-accent transition-colors">Mi perfil</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-agro-accent hover:bg-orange-600 text-white text-lg font-semibold px-5 py-2 rounded-lg transition-colors">
                            Salir
                        </button>
                    </form>
                @endauth
            </div>

        </div>
    </header>

    <main class="flex-grow max-w-7xl mx-auto w-full px-6 py-12">

        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-bold text-agro-primary">Mis productos</h1>
            <a href="{{ route('pg.anadir.producto') }}"
               class="bg-agro-accent hover:bg-orange-600 text-white text-lg font-semibold px-6 py-3 rounded-xl transition-colors">
                + Crear nuevo producto
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-agro-primary text-white">
                    <tr>
                        <th class="px-5 py-4 font-semibold">Imagen</th>
                        <th class="px-5 py-4 font-semibold">Producto</th>
                        <th class="px-5 py-4 font-semibold">Variedad</th>
                        <th class="px-5 py-4 font-semibold">Origen</th>
                        <th class="px-5 py-4 font-semibold">Fecha producción</th>
                        <th class="px-5 py-4 font-semibold text-center">Stock</th>
                        <th class="px-5 py-4 font-semibold text-center">Estado</th>
                        <th class="px-5 py-4 font-semibold text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($productos as $producto)
                        <tr class="hover:bg-gray-50 transition-colors">

                            <td class="px-5 py-4">
                                @if($producto->imagen)
                                    <img src="{{ asset('storage/' . $producto->imagen) }}"
                                         alt="{{ $producto->nombre }}"
                                         class="w-16 h-16 object-cover rounded-lg">
                                @else
                                    <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center text-agro-muted text-sm">
                                        Sin imagen
                                    </div>
                                @endif
                            </td>

                            <td class="px-5 py-4 font-semibold">{{ $producto->nombre }}</td>
                            <td class="px-5 py-4 text-agro-muted">{{ $producto->variedad }}</td>
                            <td class="px-5 py-4 text-agro-muted">{{ $producto->localizacion->nombreCalle ?? 'No asignada' }}</td>
                            <td class="px-5 py-4 text-agro-muted">{{ $producto->fechaProduccion }}</td>

                            <td class="px-5 py-4 text-center font-bold">
                                {{ $producto->stock }} uds.
                            </td>

                            <td class="px-5 py-4 text-center">
                                @if($producto->stock <= 0)
                                    <span class="bg-red-100 text-red-700 font-semibold px-3 py-1 rounded-full text-base">Agotado</span>
                                @elseif($producto->stock <= 10)
                                    <span class="bg-orange-100 text-orange-700 font-semibold px-3 py-1 rounded-full text-base">Últimas unidades</span>
                                @else
                                    <span class="bg-green-100 text-green-700 font-semibold px-3 py-1 rounded-full text-base">Disponible</span>
                                @endif
                            </td>

                            <td class="px-5 py-4 text-center">
                                <div class="flex items-center justify-center gap-3">
                                    <a href="{{ route('productos.edit', $producto->id) }}"
                                       class="bg-agro-primary hover:bg-agro-secondary text-white font-semibold px-4 py-2 rounded-lg transition-colors">
                                        Editar
                                    </a>
                                    <form action="{{ route('borrar.producto', $producto->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                onclick="return confirm('¿Estás seguro de que deseas eliminar este producto?')"
                                                class="bg-red-500 hover:bg-red-600 text-white font-semibold px-4 py-2 rounded-lg transition-colors">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
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