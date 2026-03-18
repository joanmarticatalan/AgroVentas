<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - AgroVentas</title>
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
        <div class="bg-white rounded-2xl shadow-lg p-10 w-full max-w-2xl">

            <h1 class="text-3xl font-bold text-agro-primary text-center mb-8">Crear cuenta</h1>

            <form action="{{ route('register') }}" method="POST" class="flex flex-col gap-5">
                @csrf

                {{-- Nombre --}}
                <div class="flex flex-col gap-2">
                    <label for="name" class="font-semibold">Nombre completo</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                           class="border border-gray-300 rounded-lg px-4 py-3 text-lg focus:outline-none focus:border-agro-primary">
                    @error('name') <span class="text-red-600 text-base">{{ $message }}</span> @enderror
                </div>

                {{-- Email --}}
                <div class="flex flex-col gap-2">
                    <label for="email" class="font-semibold">Correo electrónico</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                           class="border border-gray-300 rounded-lg px-4 py-3 text-lg focus:outline-none focus:border-agro-primary">
                    @error('email') <span class="text-red-600 text-base">{{ $message }}</span> @enderror
                </div>

                {{-- Contraseña --}}
                <div class="flex flex-col gap-2">
                    <label for="password" class="font-semibold">Contraseña</label>
                    <input type="password" id="password" name="password" required
                           class="border border-gray-300 rounded-lg px-4 py-3 text-lg focus:outline-none focus:border-agro-primary">
                    @error('password') <span class="text-red-600 text-base">{{ $message }}</span> @enderror
                </div>

                {{-- Repetir contraseña --}}
                <div class="flex flex-col gap-2">
                    <label for="password_confirmation" class="font-semibold">Repetir contraseña</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required
                           class="border border-gray-300 rounded-lg px-4 py-3 text-lg focus:outline-none focus:border-agro-primary">
                </div>

                {{-- Teléfono --}}
                <div class="flex flex-col gap-2">
                    <label for="telefono" class="font-semibold">Teléfono</label>
                    <input type="text" id="telefono" name="telefono" value="{{ old('telefono') }}" required
                           class="border border-gray-300 rounded-lg px-4 py-3 text-lg focus:outline-none focus:border-agro-primary">
                    @error('telefono') <span class="text-red-600 text-base">{{ $message }}</span> @enderror
                </div>

                {{-- Tipo de cliente --}}
                <div class="flex flex-col gap-2">
                    <label for="tipoCliente" class="font-semibold">Tipo de cliente</label>
                    <select id="tipoCliente" name="tipoCliente" required
                            class="border border-gray-300 rounded-lg px-4 py-3 text-lg focus:outline-none focus:border-agro-primary bg-white">
                        <option value="">Selecciona un tipo de cliente</option>
                        <option value="comprador" {{ old('tipoCliente') == 'comprador' ? 'selected' : '' }}>Comprador</option>
                        <option value="vendedor" {{ old('tipoCliente') == 'vendedor' ? 'selected' : '' }}>Vendedor</option>
                        <option value="compraventa" {{ old('tipoCliente') == 'compraventa' ? 'selected' : '' }}>Compra-Venta</option>
                    </select>
                    @error('tipoCliente') <span class="text-red-600 text-base">{{ $message }}</span> @enderror
                </div>

                {{-- Localización existente --}}
                <div class="border border-gray-200 rounded-xl p-6 flex flex-col gap-3">
                    <h3 class="text-xl font-semibold text-agro-primary">Usar localización existente</h3>
                    <p class="text-agro-muted text-base">Si seleccionas una, se usará esta. Si no, puedes crear una nueva abajo.</p>
                    <select name="localizacion_id"
                            class="border border-gray-300 rounded-lg px-4 py-3 text-lg focus:outline-none focus:border-agro-primary bg-white">
                        <option value="">-- Ninguna (opcional) --</option>
                        @foreach($localizaciones as $loc)
                            <option value="{{ $loc->id }}" {{ old('localizacion_id') == $loc->id ? 'selected' : '' }}>
                                {{ $loc->nombreCalle }}, {{ $loc->numero }} ({{ $loc->provincia }})
                            </option>
                        @endforeach
                    </select>
                    @error('localizacion_id') <span class="text-red-600 text-base">{{ $message }}</span> @enderror
                </div>

                {{-- Nueva localización --}}
                <div class="border border-gray-200 rounded-xl p-6 flex flex-col gap-4">
                    <h3 class="text-xl font-semibold text-agro-primary">Crear nueva localización</h3>
                    <p class="text-agro-muted text-base">Rellena estos campos solo si quieres crear una nueva dirección.</p>

                    <div class="flex flex-col gap-2">
                        <label class="font-semibold">Provincia</label>
                        <input type="text" name="nueva_provincia" value="{{ old('nueva_provincia') }}" maxlength="50"
                               class="border border-gray-300 rounded-lg px-4 py-3 text-lg focus:outline-none focus:border-agro-primary">
                        @error('nueva_provincia') <span class="text-red-600 text-base">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="font-semibold">Código Postal</label>
                        <input type="text" name="nueva_codigoPostal" value="{{ old('nueva_codigoPostal') }}" maxlength="5"
                               class="border border-gray-300 rounded-lg px-4 py-3 text-lg focus:outline-none focus:border-agro-primary">
                        @error('nueva_codigoPostal') <span class="text-red-600 text-base">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="font-semibold">Calle</label>
                        <input type="text" name="nueva_nombreCalle" value="{{ old('nueva_nombreCalle') }}" maxlength="50"
                               class="border border-gray-300 rounded-lg px-4 py-3 text-lg focus:outline-none focus:border-agro-primary">
                        @error('nueva_nombreCalle') <span class="text-red-600 text-base">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex flex-col gap-2">
                            <label class="font-semibold">Número</label>
                            <input type="text" name="nueva_numero" value="{{ old('nueva_numero') }}" maxlength="5"
                                   class="border border-gray-300 rounded-lg px-4 py-3 text-lg focus:outline-none focus:border-agro-primary">
                            @error('nueva_numero') <span class="text-red-600 text-base">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex flex-col gap-2">
                            <label class="font-semibold">Puerta <span class="text-agro-muted font-normal">(opcional)</span></label>
                            <input type="text" name="nueva_puerta" value="{{ old('nueva_puerta') }}" maxlength="10"
                                   class="border border-gray-300 rounded-lg px-4 py-3 text-lg focus:outline-none focus:border-agro-primary">
                            @error('nueva_puerta') <span class="text-red-600 text-base">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <button type="submit"
                        class="bg-agro-primary hover:bg-agro-secondary text-white text-xl font-semibold py-4 rounded-xl transition-colors mt-2">
                    Registrarse
                </button>

                <p class="text-center text-agro-muted">
                    ¿Ya tienes cuenta?
                    <a href="/login" class="text-agro-primary font-semibold hover:text-agro-secondary transition-colors">Inicia sesión</a>
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