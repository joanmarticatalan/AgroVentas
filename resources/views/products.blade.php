<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos - AgroVentas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-agro-bg text-slate-900 min-h-screen flex flex-col">
    @php
        $hasActiveFilters = collect($filters)->except('invalid_ranges')->contains(function ($value, $key) {
            if ($key === 'disponibilidad') {
                return $value !== 'all';
            }

            if ($key === 'sort') {
                return $value !== 'recent';
            }

            return filled($value);
        });
    @endphp

    <header class="bg-agro-primary shadow-md">
        <div class="max-w-7xl mx-auto px-6 py-4 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex items-center justify-between gap-4">
                <a href="{{ route('inicio') }}" class="text-white text-2xl font-bold tracking-wide">AgroVentas</a>
                <a href="{{ route('carrito.all') }}" class="lg:hidden text-white text-base font-medium hover:text-agro-accent transition-colors">
                    Carrito
                </a>
            </div>

            <nav class="flex flex-wrap items-center gap-x-5 gap-y-2 text-sm font-medium lg:text-base">
                <a href="{{ route('inicio') }}" class="text-white hover:text-agro-accent transition-colors">Inicio</a>
                <a href="{{ route('todos.productos') }}" class="text-agro-accent">Productos</a>
                @auth
                    <a href="{{ route('pedidos.usuario') }}" class="text-white hover:text-agro-accent transition-colors">Mis pedidos</a>
                    @if(auth()->user()->tipoCliente === 'vendedor' || auth()->user()->tipoCliente === 'compraventa')
                        <a href="{{ route('mis.productos') }}" class="text-white hover:text-agro-accent transition-colors">Mis productos</a>
                        <a href="{{ route('pedidos.vendedor') }}" class="text-white hover:text-agro-accent transition-colors">Pedidos</a>
                        <a href="{{ route('pg.anadir.producto') }}" class="text-white hover:text-agro-accent transition-colors">Añadir producto</a>
                    @endif
                    @if(auth()->user()->tipoCliente === 'admin')
                        <a href="{{ route('users.index') }}" class="text-white hover:text-agro-accent transition-colors">Gestión usuarios</a>
                    @endif
                @endauth
            </nav>

            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('carrito.all') }}" class="hidden lg:inline-flex text-white hover:text-agro-accent transition-colors">Carrito</a>
                @auth
                    <a href="{{ route('perfil.editar') }}" class="text-white hover:text-agro-accent transition-colors">Mi perfil</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-agro-accent hover:bg-orange-600 text-white font-semibold px-4 py-2 rounded-xl transition-colors">
                            Salir
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-white hover:text-agro-accent transition-colors">Entrar</a>
                    <a href="{{ route('register') }}" class="bg-agro-accent hover:bg-orange-600 text-white font-semibold px-4 py-2 rounded-xl transition-colors">
                        Crear cuenta
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <main class="flex-1">
        <section class="max-w-7xl mx-auto px-6 py-8 lg:py-9">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <h1 class="text-2xl font-black tracking-tight text-agro-primary sm:text-3xl">
                        Productos
                    </h1>
                    <p class="mt-1 text-sm text-slate-600">
                        {{ $products->count() }} {{ $products->count() === 1 ? 'producto disponible' : 'productos disponibles' }}
                    </p>
                </div>

                <div class="text-sm text-slate-600 sm:text-right">
                    @if($hasActiveFilters)
                        <p class="font-semibold text-agro-brown">Filtros activos</p>
                        <p>Mostrando coincidencias del filtro</p>
                    @else
                        <p>Usa los filtros para afinar el catálogo</p>
                    @endif
                </div>
            </div>

            <details class="group mt-5 overflow-hidden rounded-[1.75rem] bg-white shadow-lg shadow-agro-primary/10 ring-1 ring-agro-primary/10" @if($hasActiveFilters) open @endif>
                <summary class="flex cursor-pointer list-none items-center justify-between gap-4 bg-gradient-to-r from-agro-primary to-agro-secondary px-5 py-4 text-white marker:hidden [&::-webkit-details-marker]:hidden">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-green-100">Filtros</p>
                        <h2 class="mt-1 text-lg font-bold">Afinar productos</h2>
                    </div>
                    <span class="inline-flex items-center rounded-full border border-white/25 px-3 py-1 text-xs font-semibold">
                        Abrir filtros
                    </span>
                </summary>

                <div class="border-b border-slate-200 bg-gradient-to-r from-agro-primary to-agro-secondary px-5 py-3 text-white">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <p class="text-sm text-green-100">Refina el catálogo por nombre, origen, precio o fecha.</p>
                        <a href="{{ route('todos.productos') }}" class="inline-flex items-center justify-center rounded-xl border border-white/30 px-4 py-2 text-sm font-semibold text-white transition hover:bg-white/10">
                            Limpiar filtros
                        </a>
                    </div>
                </div>

                <form method="GET" action="{{ route('todos.productos') }}" class="p-5 lg:p-6">
                    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                        <div class="md:col-span-2 xl:col-span-2">
                            <label for="q-mobile" class="mb-2 block text-sm font-semibold text-slate-700">Buscar por nombre o variedad</label>
                            <input
                                id="q-mobile"
                                name="q"
                                type="text"
                                value="{{ $filters['q'] }}"
                                placeholder="Ej. tomate pera, arbequina, trigo duro"
                                class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-base text-slate-900 outline-none transition focus:border-agro-primary focus:bg-white"
                            >
                        </div>

                        <div>
                            <label for="localizacion_id-mobile" class="mb-2 block text-sm font-semibold text-slate-700">Localización</label>
                            <select
                                id="localizacion_id-mobile"
                                name="localizacion_id"
                                class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-base text-slate-900 outline-none transition focus:border-agro-primary focus:bg-white"
                            >
                                <option value="">Todas</option>
                                @foreach($localizaciones as $localizacion)
                                    <option value="{{ $localizacion->id }}" @selected($filters['localizacion_id'] == (string) $localizacion->id)>
                                        {{ $localizacion->provincia }} · {{ $localizacion->nombreCalle }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="disponibilidad-mobile" class="mb-2 block text-sm font-semibold text-slate-700">Disponibilidad</label>
                            <select
                                id="disponibilidad-mobile"
                                name="disponibilidad"
                                class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-base text-slate-900 outline-none transition focus:border-agro-primary focus:bg-white"
                            >
                                <option value="all" @selected($filters['disponibilidad'] === 'all')>Todo el catálogo</option>
                                <option value="available" @selected($filters['disponibilidad'] === 'available')>Solo disponibles</option>
                            </select>
                        </div>

                        <div>
                            <label for="precio_min-mobile" class="mb-2 block text-sm font-semibold text-slate-700">Precio mínimo</label>
                            <input
                                id="precio_min-mobile"
                                name="precio_min"
                                type="number"
                                step="0.01"
                                min="0"
                                value="{{ $filters['precio_min'] }}"
                                class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-base text-slate-900 outline-none transition focus:border-agro-primary focus:bg-white"
                            >
                        </div>

                        <div>
                            <label for="precio_max-mobile" class="mb-2 block text-sm font-semibold text-slate-700">Precio máximo</label>
                            <input
                                id="precio_max-mobile"
                                name="precio_max"
                                type="number"
                                step="0.01"
                                min="0"
                                value="{{ $filters['precio_max'] }}"
                                class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-base text-slate-900 outline-none transition focus:border-agro-primary focus:bg-white"
                            >
                        </div>

                        <div>
                            <label for="fecha_desde-mobile" class="mb-2 block text-sm font-semibold text-slate-700">Producción desde</label>
                            <input
                                id="fecha_desde-mobile"
                                name="fecha_desde"
                                type="date"
                                value="{{ $filters['fecha_desde'] }}"
                                class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-base text-slate-900 outline-none transition focus:border-agro-primary focus:bg-white"
                            >
                        </div>

                        <div>
                            <label for="fecha_hasta-mobile" class="mb-2 block text-sm font-semibold text-slate-700">Producción hasta</label>
                            <input
                                id="fecha_hasta-mobile"
                                name="fecha_hasta"
                                type="date"
                                value="{{ $filters['fecha_hasta'] }}"
                                class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-base text-slate-900 outline-none transition focus:border-agro-primary focus:bg-white"
                            >
                        </div>

                        <div>
                            <label for="sort-mobile" class="mb-2 block text-sm font-semibold text-slate-700">Ordenar por</label>
                            <select
                                id="sort-mobile"
                                name="sort"
                                class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-base text-slate-900 outline-none transition focus:border-agro-primary focus:bg-white"
                            >
                                <option value="recent" @selected($filters['sort'] === 'recent')>Más recientes</option>
                                <option value="price_asc" @selected($filters['sort'] === 'price_asc')>Precio ascendente</option>
                                <option value="price_desc" @selected($filters['sort'] === 'price_desc')>Precio descendente</option>
                                <option value="name_asc" @selected($filters['sort'] === 'name_asc')>Nombre A-Z</option>
                            </select>
                        </div>
                    </div>

                    @if(! empty($filters['invalid_ranges']))
                        <div class="mt-4 rounded-2xl border border-orange-200 bg-orange-50 px-4 py-3 text-sm text-orange-800">
                            Algunos rangos no se han aplicado porque estaban invertidos. Revisa precio o fechas si quieres afinar más la búsqueda.
                        </div>
                    @endif

                    <div class="mt-5 flex flex-col gap-3 sm:flex-row sm:items-center">
                        <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-agro-primary px-6 py-3 text-base font-semibold text-white transition hover:bg-agro-secondary">
                            Aplicar filtros
                        </button>
                        <a href="{{ route('todos.productos') }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-300 px-6 py-3 text-base font-semibold text-slate-700 transition hover:border-agro-primary hover:text-agro-primary">
                            Limpiar
                        </a>
                    </div>
                </form>
            </details>

            <section class="mt-6">
                <div class="mb-6 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-agro-brown">Catálogo</p>
                        <h2 class="mt-1 text-2xl font-bold text-agro-primary">
                            {{ $products->count() }} {{ $products->count() === 1 ? 'producto encontrado' : 'productos encontrados' }}
                        </h2>
                    </div>

                    @if($hasActiveFilters)
                        <p class="text-sm text-slate-600">Mostrando solo los productos que cumplen tus filtros activos.</p>
                    @else
                        <p class="text-sm text-slate-600">Vista general del mercado disponible ahora mismo.</p>
                    @endif
                </div>

                @if($products->isEmpty())
                    <div class="rounded-[2rem] border border-dashed border-agro-primary/25 bg-white px-6 py-14 text-center shadow-sm">
                        <div class="mx-auto max-w-2xl space-y-4">
                            <span class="inline-flex rounded-full bg-agro-bg px-4 py-1 text-sm font-semibold text-agro-brown">Sin coincidencias</span>
                            <h3 class="text-3xl font-black text-agro-primary">No hemos encontrado productos</h3>
                            <p class="text-lg text-slate-600">
                                Prueba a ampliar el rango de precio, cambiar la localización o borrar los filtros activos.
                            </p>
                            <a href="{{ route('todos.productos') }}" class="inline-flex items-center justify-center rounded-2xl bg-agro-accent px-6 py-3 text-base font-semibold text-white transition hover:bg-orange-600">
                                Limpiar filtros
                            </a>
                        </div>
                    </div>
                @else
                    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                        @foreach($products as $prod)
                            <article class="group overflow-hidden rounded-[2rem] bg-white shadow-lg shadow-agro-primary/10 ring-1 ring-agro-primary/10 transition hover:-translate-y-1 hover:shadow-2xl">
                                <div class="relative h-52 overflow-hidden bg-gradient-to-br from-agro-primary via-agro-secondary to-agro-brown">
                                    @if($prod->imagen)
                                        <img
                                            src="{{ asset('storage/' . $prod->imagen) }}"
                                            alt="{{ $prod->nombre }}"
                                            class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                                        >
                                    @else
                                        <div class="flex h-full items-center justify-center text-lg font-semibold text-white/90">
                                            Sin imagen
                                        </div>
                                    @endif

                                    <div class="absolute left-4 top-4">
                                        @if($prod->stock > 0)
                                            <span class="rounded-full bg-white/90 px-3 py-1 text-xs font-bold uppercase tracking-[0.2em] text-agro-primary">
                                                Disponible
                                            </span>
                                        @else
                                            <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-bold uppercase tracking-[0.2em] text-red-700">
                                                Agotado
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="space-y-5 p-6">
                                    <div class="flex items-start justify-between gap-4">
                                        <div>
                                            <p class="text-sm font-semibold uppercase tracking-[0.16em] text-agro-brown">{{ $prod->variedad }}</p>
                                            <h3 class="mt-2 text-2xl font-black text-agro-primary">{{ $prod->nombre }}</h3>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Precio</p>
                                            <p class="mt-2 text-2xl font-black text-slate-900">{{ number_format((float) $prod->precio, 2, ',', '.') }} €</p>
                                        </div>
                                    </div>

                                    <dl class="grid gap-3 text-sm text-slate-700 sm:grid-cols-2">
                                        <div class="rounded-2xl bg-slate-50 px-4 py-3">
                                            <dt class="font-semibold text-slate-500">Vendedor</dt>
                                            <dd class="mt-1 font-semibold text-slate-900">{{ $prod->vendedor->name ?? 'Desconocido' }}</dd>
                                        </div>
                                        <div class="rounded-2xl bg-slate-50 px-4 py-3">
                                            <dt class="font-semibold text-slate-500">Origen</dt>
                                            <dd class="mt-1 font-semibold text-slate-900">
                                                {{ $prod->localizacion->provincia ?? 'Sin provincia' }}
                                            </dd>
                                        </div>
                                        <div class="rounded-2xl bg-slate-50 px-4 py-3">
                                            <dt class="font-semibold text-slate-500">Stock</dt>
                                            <dd class="mt-1 font-semibold text-slate-900">{{ $prod->stock }} uds.</dd>
                                        </div>
                                        <div class="rounded-2xl bg-slate-50 px-4 py-3">
                                            <dt class="font-semibold text-slate-500">Producción</dt>
                                            <dd class="mt-1 font-semibold text-slate-900">{{ $prod->fechaProduccion }}</dd>
                                        </div>
                                    </dl>

                                    <a href="{{ route('ver.producto', $prod->id) }}" class="inline-flex w-full items-center justify-center rounded-2xl bg-agro-primary px-5 py-3 text-base font-semibold text-white transition hover:bg-agro-secondary">
                                        Ver detalle del producto
                                    </a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @endif
            </section>
        </section>
    </main>
</body>
</html>
