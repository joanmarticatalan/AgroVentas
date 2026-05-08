<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ficha de usuario - AgroVentas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-agro-bg text-agro-text min-h-screen flex flex-col">
    <header class="bg-agro-primary shadow-md">
        <div class="max-w-7xl mx-auto px-6 py-4 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <a href="{{ route('inicio') }}" class="text-white text-2xl font-bold tracking-wide">AgroVentas</a>
            <nav class="flex flex-wrap items-center gap-5 text-sm font-medium lg:text-base">
                <a href="{{ route('users.index') }}" class="text-agro-accent">Gestión usuarios</a>
                <a href="{{ route('users.edit', $user) }}" class="text-white hover:text-agro-accent transition-colors">Editar</a>
            </nav>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-agro-accent hover:bg-orange-600 text-white font-semibold px-4 py-2 rounded-xl transition-colors">Salir</button>
            </form>
        </div>
    </header>

    <main class="flex-1">
        <section class="max-w-5xl mx-auto px-6 py-10 lg:py-12">
            <div class="rounded-[2rem] bg-white p-8 shadow-xl shadow-agro-primary/10 ring-1 ring-agro-primary/10">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.22em] text-agro-brown">Ficha de usuario</p>
                        <h1 class="mt-2 text-4xl font-black tracking-tight text-agro-primary">{{ $user->name }}</h1>
                        <p class="mt-2 text-slate-600">{{ $user->email }}</p>
                    </div>
                    <div class="flex flex-col gap-3 sm:flex-row">
                        <a href="{{ route('users.edit', $user) }}" class="inline-flex items-center justify-center rounded-2xl bg-agro-primary px-5 py-3 text-sm font-semibold text-white transition hover:bg-agro-secondary">Editar usuario</a>
                        <a href="{{ route('users.index') }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-300 px-5 py-3 text-sm font-semibold text-slate-700 transition hover:border-agro-primary hover:text-agro-primary">Volver al panel</a>
                    </div>
                </div>

                <div class="mt-8 grid gap-4 md:grid-cols-2">
                    <article class="rounded-[1.5rem] bg-slate-50 p-5 ring-1 ring-slate-200">
                        <p class="text-sm font-semibold uppercase tracking-[0.18em] text-slate-500">Rol</p>
                        <p class="mt-3 text-2xl font-bold text-agro-primary">{{ ucfirst($user->tipoCliente) }}</p>
                    </article>
                    <article class="rounded-[1.5rem] bg-slate-50 p-5 ring-1 ring-slate-200">
                        <p class="text-sm font-semibold uppercase tracking-[0.18em] text-slate-500">Teléfono</p>
                        <p class="mt-3 text-2xl font-bold text-agro-primary">{{ $user->telefono }}</p>
                    </article>
                    <article class="rounded-[1.5rem] bg-slate-50 p-5 ring-1 ring-slate-200 md:col-span-2">
                        <p class="text-sm font-semibold uppercase tracking-[0.18em] text-slate-500">Localización</p>
                        <p class="mt-3 text-xl font-bold text-agro-primary">
                            @if($user->localizacion)
                                {{ $user->localizacion->nombreCalle }}, {{ $user->localizacion->numero }}, {{ $user->localizacion->codigoPostal }} ({{ $user->localizacion->provincia }})
                            @else
                                Sin localización asignada
                            @endif
                        </p>
                    </article>
                    <article class="rounded-[1.5rem] bg-slate-50 p-5 ring-1 ring-slate-200">
                        <p class="text-sm font-semibold uppercase tracking-[0.18em] text-slate-500">ID</p>
                        <p class="mt-3 text-2xl font-bold text-agro-primary">#{{ $user->id }}</p>
                    </article>
                    <article class="rounded-[1.5rem] bg-slate-50 p-5 ring-1 ring-slate-200">
                        <p class="text-sm font-semibold uppercase tracking-[0.18em] text-slate-500">Alta</p>
                        <p class="mt-3 text-2xl font-bold text-agro-primary">{{ optional($user->created_at)->format('d/m/Y') ?? 'Sin fecha' }}</p>
                    </article>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
