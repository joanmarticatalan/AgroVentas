<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi perfil - AgroVentas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-agro-bg text-agro-text min-h-screen flex flex-col text-lg">

    <header class="bg-agro-primary shadow-md">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

            <a href="/" class="text-white text-2xl font-bold tracking-wide">AgroVentas</a>

            <nav class="hidden md:flex items-center gap-8">
                <a href="/" class="text-white text-lg hover:text-agro-accent transition-colors">Inicio</a>
                <a href="/products" class="text-white text-lg hover:text-agro-accent transition-colors">Productos</a>
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

    <main class="flex-grow flex items-center justify-center py-16">
        <div class="bg-white rounded-2xl shadow-lg p-10 w-full max-w-2xl">

            <h1 class="text-3xl font-bold text-agro-primary text-center mb-8">Mi perfil</h1>

            @if(session('success'))
                <div class="bg-green-100 text-green-700 rounded-lg px-5 py-4 mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('perfil.update') }}" class="flex flex-col gap-5">
                @csrf
                @method('PUT')

                <div class="flex flex-col gap-2">
                    <label for="name" class="font-semibold">Nombre</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                           class="border border-gray-300 rounded-lg px-4 py-3 text-lg focus:outline-none focus:border-agro-primary">
                    @error('name') <span class="text-red-600 text-base">{{ $message }}</span> @enderror
                </div>

                <div class="flex flex-col gap-2">
                    <label for="email" class="font-semibold">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                           class="border border-gray-300 rounded-lg px-4 py-3 text-lg focus:outline-none focus:border-agro-primary">
                    @error('email') <span class="text-red-600 text-base">{{ $message }}</span> @enderror
                </div>

                <div class="flex flex-col gap-2">
                    <label for="telefono" class="font-semibold">Teléfono</label>
                    <input type="text" id="telefono" name="telefono" value="{{ old('telefono', $user->telefono) }}" required
                           class="border border-gray-300 rounded-lg px-4 py-3 text-lg focus:outline-none focus:border-agro-primary">
                    @error('telefono') <span class="text-red-600 text-base">{{ $message }}</span> @enderror
                </div>

                <div class="border border-gray-200 rounded-xl p-6 flex flex-col gap-4">
                    <h3 class="text-xl font-semibold text-agro-primary">Cambiar contraseña</h3>
                    <p class="text-agro-muted text-base">Déjalo vacío si no quieres cambiarla.</p>

                    <div class="flex flex-col gap-2">
                        <label for="password" class="font-semibold">Nueva contraseña</label>
                        <input type="password" id="password" name="password"
                               class="border border-gray-300 rounded-lg px-4 py-3 text-lg focus:outline-none focus:border-agro-primary">
                        @error('password') <span class="text-red-600 text-base">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="password_confirmation" class="font-semibold">Repetir contraseña</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                               class="border border-gray-300 rounded-lg px-4 py-3 text-lg focus:outline-none focus:border-agro-primary">
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <label for="localizacion_id" class="font-semibold">Localización</label>
                    <select id="localizacion_id" name="localizacion_id"
                            class="border border-gray-300 rounded-lg px-4 py-3 text-lg focus:outline-none focus:border-agro-primary bg-white">
                        <option value="">-- Ninguna --</option>
                        @foreach($localizaciones as $localizacion)
                            <option value="{{ $localizacion->id }}"
                                {{ old('localizacion_id', $user->localizacion_id) == $localizacion->id ? 'selected' : '' }}>
                                {{ $localizacion->nombreCalle }}, {{ $localizacion->numero }} ({{ $localizacion->provincia }})
                            </option>
                        @endforeach
                    </select>
                    @error('localizacion_id') <span class="text-red-600 text-base">{{ $message }}</span> @enderror
                </div>

                @if(auth()->user()->tipoCliente === 'admin')
                <div class="flex flex-col gap-2">
                    <label for="tipoCliente" class="font-semibold">Tipo de cliente</label>
                    <select id="tipoCliente" name="tipoCliente"
                            class="border border-gray-300 rounded-lg px-4 py-3 text-lg focus:outline-none focus:border-agro-primary bg-white">
                        <option value="comprador" {{ old('tipoCliente', $user->tipoCliente) == 'comprador' ? 'selected' : '' }}>Comprador</option>
                        <option value="vendedor" {{ old('tipoCliente', $user->tipoCliente) == 'vendedor' ? 'selected' : '' }}>Vendedor</option>
                        <option value="compraventa" {{ old('tipoCliente', $user->tipoCliente) == 'compraventa' ? 'selected' : '' }}>Compra-Venta</option>
                    </select>
                    @error('tipoCliente') <span class="text-red-600 text-base">{{ $message }}</span> @enderror
                </div>
                @endif

                <button type="submit"
                        class="bg-agro-primary hover:bg-agro-secondary text-white text-xl font-semibold py-4 rounded-xl transition-colors mt-2">
                    Guardar cambios
                </button>

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