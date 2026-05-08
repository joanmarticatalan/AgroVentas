<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar usuario - AgroVentas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-agro-bg text-agro-text min-h-screen flex flex-col">
    <header class="bg-agro-primary shadow-md">
        <div class="max-w-7xl mx-auto px-6 py-4 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <a href="{{ route('inicio') }}" class="text-white text-2xl font-bold tracking-wide">AgroVentas</a>
            <nav class="flex flex-wrap items-center gap-5 text-sm font-medium lg:text-base">
                <a href="{{ route('users.index') }}" class="text-agro-accent">Gestión usuarios</a>
                <a href="{{ route('users.show', $user) }}" class="text-white hover:text-agro-accent transition-colors">Ficha usuario</a>
            </nav>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-agro-accent hover:bg-orange-600 text-white font-semibold px-4 py-2 rounded-xl transition-colors">Salir</button>
            </form>
        </div>
    </header>

    <main class="flex-1">
        <section class="max-w-5xl mx-auto px-6 py-10 lg:py-12">
            <div class="grid gap-8 lg:grid-cols-[0.9fr_1.1fr]">
                <div class="space-y-5">
                    <p class="text-sm font-semibold uppercase tracking-[0.22em] text-agro-brown">Administración</p>
                    <h1 class="text-4xl font-black tracking-tight text-agro-primary">Editar usuario</h1>
                    <p class="text-lg leading-8 text-slate-600">Ajusta permisos, contacto y ubicación de <span class="font-semibold text-agro-primary">{{ $user->name }}</span>.</p>
                </div>

                <div class="rounded-[2rem] bg-white p-6 shadow-xl shadow-agro-primary/10 ring-1 ring-agro-primary/10 sm:p-8">
                    @if ($errors->any())
                        <div class="rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700">
                            <ul class="space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('users.update', $user) }}" class="mt-6 space-y-6">
                        @csrf
                        @method('PUT')
                        <div class="grid gap-6 sm:grid-cols-2">
                            <div class="sm:col-span-2">
                                <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">Nombre</label>
                                <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none transition focus:border-agro-primary focus:bg-white">
                            </div>
                            <div class="sm:col-span-2">
                                <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">Email</label>
                                <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none transition focus:border-agro-primary focus:bg-white">
                            </div>
                            <div>
                                <label for="telefono" class="mb-2 block text-sm font-semibold text-slate-700">Teléfono</label>
                                <input id="telefono" name="telefono" type="text" value="{{ old('telefono', $user->telefono) }}" required class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none transition focus:border-agro-primary focus:bg-white">
                            </div>
                            <div>
                                <label for="tipoCliente" class="mb-2 block text-sm font-semibold text-slate-700">Rol</label>
                                <select id="tipoCliente" name="tipoCliente" required class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none transition focus:border-agro-primary focus:bg-white">
                                    @foreach(['comprador', 'vendedor', 'compraventa', 'admin'] as $rol)
                                        <option value="{{ $rol }}" @selected(old('tipoCliente', $user->tipoCliente) === $rol)>{{ ucfirst($rol) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="password" class="mb-2 block text-sm font-semibold text-slate-700">Nueva contraseña</label>
                                <input id="password" name="password" type="password" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none transition focus:border-agro-primary focus:bg-white">
                            </div>
                            <div>
                                <label for="password_confirmation" class="mb-2 block text-sm font-semibold text-slate-700">Confirmar contraseña</label>
                                <input id="password_confirmation" name="password_confirmation" type="password" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none transition focus:border-agro-primary focus:bg-white">
                            </div>
                            <div class="sm:col-span-2">
                                <label for="localizacion_id" class="mb-2 block text-sm font-semibold text-slate-700">Localización</label>
                                <select id="localizacion_id" name="localizacion_id" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none transition focus:border-agro-primary focus:bg-white">
                                    <option value="">Sin localización</option>
                                    @foreach($localizaciones as $localizacion)
                                        <option value="{{ $localizacion->id }}" @selected(old('localizacion_id', $user->localizacion_id) == $localizacion->id)>
                                            {{ $localizacion->nombreCalle }}, {{ $localizacion->numero }} ({{ $localizacion->provincia }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="flex flex-col gap-3 sm:flex-row">
                            <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-agro-accent px-6 py-3 text-base font-semibold text-white transition hover:bg-orange-600">Guardar cambios</button>
                            <a href="{{ route('users.show', $user) }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-300 px-6 py-3 text-base font-semibold text-slate-700 transition hover:border-agro-primary hover:text-agro-primary">Volver</a>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
