@extends('layouts.estructura-agro')

@section('title', 'Editar producto - AgroVentas')
@section('body_class', 'flex flex-col text-agro-text')
@section('content')
    <main class="flex-1">
        <section class="max-w-7xl mx-auto px-6 py-10 lg:py-12">
            <div class="grid gap-8 lg:grid-cols-[1.05fr_0.95fr] lg:items-start">
                <div class="space-y-6">
                    <div class="space-y-4">
                        <span class="inline-flex rounded-full bg-white/80 px-4 py-1 text-sm font-semibold uppercase tracking-[0.2em] text-agro-brown shadow-sm ring-1 ring-agro-primary/10">
                            Gestión de producto
                        </span>
                        <div class="space-y-3">
                            <h1 class="text-4xl font-black tracking-tight text-agro-primary sm:text-5xl">
                                Actualiza tu ficha sin perder el estilo del catálogo
                            </h1>
                            <p class="max-w-2xl text-lg leading-8 text-slate-600">
                                Revisa los datos del producto, ajusta disponibilidad o precio y cambia la imagen solo si realmente necesitas renovar la ficha.
                            </p>
                        </div>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-3">
                        <article class="rounded-[1.75rem] bg-white p-5 shadow-lg shadow-agro-primary/5 ring-1 ring-agro-primary/10">
                            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-agro-brown">Estado</p>
                            <h2 class="mt-3 text-xl font-bold text-agro-primary">
                                @if($producto->stock <= 0)
                                    Agotado
                                @elseif($producto->stock <= 10)
                                    Stock ajustado
                                @else
                                    Disponible
                                @endif
                            </h2>
                            <p class="mt-2 text-sm leading-6 text-slate-600">El estado visible dependerá del stock que guardes en esta edición.</p>
                        </article>
                        <article class="rounded-[1.75rem] bg-white p-5 shadow-lg shadow-agro-primary/5 ring-1 ring-agro-primary/10">
                            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-agro-brown">Publicado</p>
                            <h2 class="mt-3 text-xl font-bold text-agro-primary">{{ optional($producto->created_at)->format('d/m/Y') ?? 'Sin fecha' }}</h2>
                            <p class="mt-2 text-sm leading-6 text-slate-600">Mantén los datos consistentes para evitar fricción en pedidos y consultas.</p>
                        </article>
                        <article class="rounded-[1.75rem] bg-white p-5 shadow-lg shadow-agro-primary/5 ring-1 ring-agro-primary/10">
                            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-agro-brown">Precio actual</p>
                            <h2 class="mt-3 text-xl font-bold text-agro-primary">{{ number_format($producto->precio, 2, ',', '.') }} €/kg</h2>
                            <p class="mt-2 text-sm leading-6 text-slate-600">Una actualización clara de precio mejora la lectura de la ficha en catálogo.</p>
                        </article>
                    </div>

                    <div class="rounded-[2rem] bg-gradient-to-br from-agro-primary via-agro-secondary to-agro-primary p-7 text-white shadow-xl shadow-agro-primary/20">
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                            <div>
                                <p class="text-sm font-semibold uppercase tracking-[0.22em] text-green-100">Ficha actual</p>
                                <h2 class="mt-2 text-2xl font-bold">{{ $producto->nombre }}</h2>
                                <p class="mt-2 text-sm text-white/85">{{ $producto->variedad ?: 'Sin variedad especificada' }}</p>
                            </div>
                            <a href="{{ route('mis.productos') }}" class="inline-flex items-center justify-center rounded-2xl border border-white/30 px-5 py-3 text-sm font-semibold text-white transition hover:bg-white/10">
                                Volver a mis productos
                            </a>
                        </div>

                        <div class="mt-5 grid gap-3 sm:grid-cols-2">
                            <div class="rounded-2xl bg-white/10 px-4 py-4 backdrop-blur-sm">
                                <p class="text-sm font-semibold text-green-100">Stock registrado</p>
                                <p class="mt-1 text-sm leading-6 text-white/85">{{ $producto->stock }} kg disponibles actualmente.</p>
                            </div>
                            <div class="rounded-2xl bg-white/10 px-4 py-4 backdrop-blur-sm">
                                <p class="text-sm font-semibold text-green-100">Producción</p>
                                <p class="mt-1 text-sm leading-6 text-white/85">{{ \Illuminate\Support\Carbon::parse($producto->fechaProduccion)->format('d/m/Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="rounded-[2rem] bg-white p-6 shadow-xl shadow-agro-primary/10 ring-1 ring-agro-primary/10 sm:p-8">
                    <div class="flex flex-col gap-2 border-b border-slate-200 pb-6">
                        <p class="text-sm font-semibold uppercase tracking-[0.22em] text-agro-brown">Formulario</p>
                        <h2 class="text-3xl font-black tracking-tight text-agro-primary">Editar producto</h2>
                        <p class="text-sm leading-6 text-slate-600">
                            Modifica los campos necesarios y guarda. Si no subes nueva imagen, se conserva la actual.
                        </p>
                    </div>

                    @if ($errors->any())
                        <div class="mt-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700">
                            <p class="font-semibold">Revisa el formulario.</p>
                            <ul class="mt-2 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('editar.producto', $producto->id) }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid gap-6 sm:grid-cols-2">
                            <div class="sm:col-span-2">
                                <label for="nombre" class="mb-2 block text-sm font-semibold text-slate-700">Nombre del producto</label>
                                <input
                                    id="nombre"
                                    type="text"
                                    name="nombre"
                                    value="{{ old('nombre', $producto->nombre) }}"
                                    required
                                    maxlength="25"
                                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-base text-slate-900 outline-none transition focus:border-agro-primary focus:bg-white"
                                >
                            </div>

                            <div class="sm:col-span-2">
                                <label for="variedad" class="mb-2 block text-sm font-semibold text-slate-700">Variedad</label>
                                <input
                                    id="variedad"
                                    type="text"
                                    name="variedad"
                                    value="{{ old('variedad', $producto->variedad) }}"
                                    maxlength="50"
                                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-base text-slate-900 outline-none transition focus:border-agro-primary focus:bg-white"
                                >
                            </div>

                            <div>
                                <label for="stock" class="mb-2 block text-sm font-semibold text-slate-700">Stock (kg)</label>
                                <input
                                    id="stock"
                                    type="number"
                                    name="stock"
                                    value="{{ old('stock', $producto->stock) }}"
                                    min="0"
                                    required
                                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-base text-slate-900 outline-none transition focus:border-agro-primary focus:bg-white"
                                >
                            </div>

                            <div>
                                <label for="precio" class="mb-2 block text-sm font-semibold text-slate-700">Precio (€/kg)</label>
                                <input
                                    id="precio"
                                    type="number"
                                    step="0.01"
                                    name="precio"
                                    value="{{ old('precio', $producto->precio) }}"
                                    min="0"
                                    required
                                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-base text-slate-900 outline-none transition focus:border-agro-primary focus:bg-white"
                                >
                            </div>

                            <div>
                                <label for="fecha" class="mb-2 block text-sm font-semibold text-slate-700">Fecha de producción</label>
                                <input
                                    id="fecha"
                                    type="date"
                                    name="fecha"
                                    value="{{ old('fecha', $producto->fechaProduccion) }}"
                                    required
                                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-base text-slate-900 outline-none transition focus:border-agro-primary focus:bg-white"
                                >
                            </div>

                            <div>
                                <label for="localizacion_id" class="mb-2 block text-sm font-semibold text-slate-700">Ubicación</label>
                                <select
                                    id="localizacion_id"
                                    name="localizacion_id"
                                    required
                                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-base text-slate-900 outline-none transition focus:border-agro-primary focus:bg-white"
                                >
                                    <option value="">Seleccione una localización</option>
                                    @foreach($localizaciones as $loc)
                                        <option value="{{ $loc->id }}" @selected(old('localizacion_id', $producto->localizacion_id) == $loc->id)>
                                            {{ $loc->nombreCalle }}, {{ $loc->numero }} ({{ $loc->provincia }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="sm:col-span-2 grid gap-4 lg:grid-cols-[0.9fr_1.1fr]">
                                <div class="rounded-[1.5rem] border border-slate-200 bg-slate-50 p-4">
                                    <p class="text-sm font-semibold text-slate-700">Imagen actual</p>
                                    <div class="mt-4 overflow-hidden rounded-2xl bg-white ring-1 ring-slate-200">
                                        @if($producto->imagen)
                                            <img
                                                src="{{ asset('storage/' . $producto->imagen) }}"
                                                alt="{{ $producto->nombre }}"
                                                class="h-56 w-full object-cover"
                                            >
                                        @else
                                            <div class="flex h-56 items-center justify-center text-sm font-semibold text-slate-500">
                                                Este producto no tiene imagen
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="rounded-[1.5rem] border border-dashed border-agro-primary/25 bg-agro-bg/60 p-4">
                                    <label for="imagen" class="block text-sm font-semibold text-slate-700">Nueva imagen (opcional)</label>
                                    <input
                                        id="imagen"
                                        type="file"
                                        name="imagen"
                                        accept="image/*"
                                        class="mt-4 block w-full text-sm text-slate-600 file:mr-4 file:rounded-full file:border-0 file:bg-agro-primary file:px-4 file:py-2 file:font-semibold file:text-white hover:file:bg-agro-secondary"
                                    >
                                    <p class="mt-3 text-sm leading-6 text-slate-500">
                                        Si no seleccionas ninguna imagen, AgroVentas conservará la actual.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-[1.75rem] bg-slate-50 px-5 py-5 ring-1 ring-slate-200">
                            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-agro-brown">Acciones</p>
                            <div class="mt-4 grid gap-3 sm:grid-cols-2">
                                <div class="rounded-2xl bg-white px-4 py-4">
                                    <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Guardar cambios</p>
                                    <p class="mt-2 text-lg font-bold text-agro-primary">Actualiza la ficha pública del producto.</p>
                                </div>
                                <div class="rounded-2xl bg-white px-4 py-4">
                                    <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Volver</p>
                                    <p class="mt-2 text-lg font-bold text-agro-primary">Regresa a “Mis productos” sin cambiar de flujo.</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                            <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-agro-accent px-6 py-3 text-base font-semibold text-white transition hover:bg-orange-600">
                                Guardar cambios
                            </button>
                            <a href="{{ route('mis.productos') }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-300 px-6 py-3 text-base font-semibold text-slate-700 transition hover:border-agro-primary hover:text-agro-primary">
                                Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
@endsection
