@extends('layouts.estructura-agro')

@section('title', 'Nuevo producto - AgroVentas')
@section('body_class', 'flex flex-col text-agro-text')
@section('content')

    <main class="flex-1">
        <section class="max-w-7xl mx-auto px-6 py-10 lg:py-12">
            <div class="grid gap-8 lg:grid-cols-[1.05fr_0.95fr] lg:items-start">
                <div class="space-y-6">
                    <div class="space-y-4">
                        <span class="inline-flex rounded-full bg-white/80 px-4 py-1 text-sm font-semibold uppercase tracking-[0.2em] text-agro-brown shadow-sm ring-1 ring-agro-primary/10">
                            Panel vendedor
                        </span>
                        <div class="space-y-3">
                            <h1 class="text-4xl font-black tracking-tight text-agro-primary sm:text-5xl">
                                Publica un producto con una ficha clara y lista para vender
                            </h1>
                            <p class="max-w-2xl text-lg leading-8 text-slate-600">
                                Completa los datos clave de cultivo, precio y localización para que tu producto entre en el catálogo con el mismo acabado que el resto de AgroVentas.
                            </p>
                        </div>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-3">
                        <article class="rounded-[1.75rem] bg-white p-5 shadow-lg shadow-agro-primary/5 ring-1 ring-agro-primary/10">
                            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-agro-brown">Paso 1</p>
                            <h2 class="mt-3 text-xl font-bold text-agro-primary">Describe</h2>
                            <p class="mt-2 text-sm leading-6 text-slate-600">Nombre y variedad para que el comprador identifique rápido lo que vendes.</p>
                        </article>
                        <article class="rounded-[1.75rem] bg-white p-5 shadow-lg shadow-agro-primary/5 ring-1 ring-agro-primary/10">
                            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-agro-brown">Paso 2</p>
                            <h2 class="mt-3 text-xl font-bold text-agro-primary">Ajusta</h2>
                            <p class="mt-2 text-sm leading-6 text-slate-600">Define stock, fecha y precio por kilo para mostrar disponibilidad real.</p>
                        </article>
                        <article class="rounded-[1.75rem] bg-white p-5 shadow-lg shadow-agro-primary/5 ring-1 ring-agro-primary/10">
                            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-agro-brown">Paso 3</p>
                            <h2 class="mt-3 text-xl font-bold text-agro-primary">Presenta</h2>
                            <p class="mt-2 text-sm leading-6 text-slate-600">Sube una imagen y vincula la ubicación para dar confianza desde la ficha.</p>
                        </article>
                    </div>

                    <div class="rounded-[2rem] bg-gradient-to-br from-agro-primary via-agro-secondary to-agro-primary p-7 text-white shadow-xl shadow-agro-primary/20">
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                            <div>
                                <p class="text-sm font-semibold uppercase tracking-[0.22em] text-green-100">Consejo</p>
                                <h2 class="mt-2 text-2xl font-bold">Las fichas completas convierten mejor</h2>
                            </div>
                            <a href="{{ route('mis.productos') }}" class="inline-flex items-center justify-center rounded-2xl border border-white/30 px-5 py-3 text-sm font-semibold text-white transition hover:bg-white/10">
                                Ver mis productos
                            </a>
                        </div>
                        <div class="mt-5 grid gap-3 sm:grid-cols-2">
                            <div class="rounded-2xl bg-white/10 px-4 py-4 backdrop-blur-sm">
                                <p class="text-sm font-semibold text-green-100">Imagen recomendada</p>
                                <p class="mt-1 text-sm leading-6 text-white/85">Usa una foto nítida del producto, con buena luz y fondo limpio.</p>
                            </div>
                            <div class="rounded-2xl bg-white/10 px-4 py-4 backdrop-blur-sm">
                                <p class="text-sm font-semibold text-green-100">Precio y stock</p>
                                <p class="mt-1 text-sm leading-6 text-white/85">Mantén estos datos actualizados para evitar pedidos sobre producto agotado.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="rounded-[2rem] bg-white p-6 shadow-xl shadow-agro-primary/10 ring-1 ring-agro-primary/10 sm:p-8">
                    <div class="flex flex-col gap-2 border-b border-slate-200 pb-6">
                        <p class="text-sm font-semibold uppercase tracking-[0.22em] text-agro-brown">Formulario</p>
                        <h2 class="text-3xl font-black tracking-tight text-agro-primary">Nuevo producto</h2>
                        <p class="text-sm leading-6 text-slate-600">
                            Todos los campos son obligatorios salvo la variedad, aunque conviene completarla para mejorar la búsqueda.
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

                    <form action="{{ route('subir.producto') }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-6">
                        @csrf

                        <div class="grid gap-6 sm:grid-cols-2">
                            <div class="sm:col-span-2">
                                <label for="nombre" class="mb-2 block text-sm font-semibold text-slate-700">Nombre del producto</label>
                                <input
                                    id="nombre"
                                    type="text"
                                    name="nombre"
                                    value="{{ old('nombre') }}"
                                    required
                                    maxlength="25"
                                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-base text-slate-900 outline-none transition focus:border-agro-primary focus:bg-white"
                                    placeholder="Ej. Naranjas de mesa"
                                >
                            </div>

                            <div class="sm:col-span-2">
                                <label for="variedad" class="mb-2 block text-sm font-semibold text-slate-700">Variedad</label>
                                <input
                                    id="variedad"
                                    type="text"
                                    name="variedad"
                                    value="{{ old('variedad') }}"
                                    maxlength="50"
                                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-base text-slate-900 outline-none transition focus:border-agro-primary focus:bg-white"
                                    placeholder="Ej. Lane Late"
                                >
                            </div>

                            <div>
                                <label for="stock" class="mb-2 block text-sm font-semibold text-slate-700">Stock (kg)</label>
                                <input
                                    id="stock"
                                    type="number"
                                    name="stock"
                                    value="{{ old('stock') }}"
                                    min="0"
                                    required
                                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-base text-slate-900 outline-none transition focus:border-agro-primary focus:bg-white"
                                    placeholder="0"
                                >
                            </div>

                            <div>
                                <label for="precio" class="mb-2 block text-sm font-semibold text-slate-700">Precio (€/kg)</label>
                                <input
                                    id="precio"
                                    type="number"
                                    step="0.01"
                                    name="precio"
                                    value="{{ old('precio') }}"
                                    min="0"
                                    required
                                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-base text-slate-900 outline-none transition focus:border-agro-primary focus:bg-white"
                                    placeholder="0.00"
                                >
                            </div>

                            <div>
                                <label for="fecha" class="mb-2 block text-sm font-semibold text-slate-700">Fecha de producción</label>
                                <input
                                    id="fecha"
                                    type="date"
                                    name="fecha"
                                    value="{{ old('fecha') }}"
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
                                        <option value="{{ $loc->id }}" @selected(old('localizacion_id') == $loc->id)>
                                            {{ $loc->nombreCalle }}, {{ $loc->numero }} ({{ $loc->provincia }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="imagen" class="mb-2 block text-sm font-semibold text-slate-700">Imagen del producto</label>
                                <div class="rounded-[1.5rem] border border-dashed border-agro-primary/25 bg-agro-bg/60 p-4">
                                    <input
                                        id="imagen"
                                        type="file"
                                        name="imagen"
                                        accept="image/*"
                                        required
                                        class="block w-full text-sm text-slate-600 file:mr-4 file:rounded-full file:border-0 file:bg-agro-primary file:px-4 file:py-2 file:font-semibold file:text-white hover:file:bg-agro-secondary"
                                    >
                                    <p class="mt-3 text-sm text-slate-500">Formatos admitidos: JPG, PNG o GIF. Tamaño máximo: 2 MB.</p>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-[1.75rem] bg-slate-50 px-5 py-5 ring-1 ring-slate-200">
                            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-agro-brown">Vista rápida</p>
                            <div class="mt-4 grid gap-3 sm:grid-cols-2">
                                <div class="rounded-2xl bg-white px-4 py-4">
                                    <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Catálogo</p>
                                    <p class="mt-2 text-lg font-bold text-agro-primary">Tu producto aparecerá en el listado general.</p>
                                </div>
                                <div class="rounded-2xl bg-white px-4 py-4">
                                    <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Gestión</p>
                                    <p class="mt-2 text-lg font-bold text-agro-primary">Luego podrás editarlo desde “Mis productos”.</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                            <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-agro-accent px-6 py-3 text-base font-semibold text-white transition hover:bg-orange-600">
                                Crear producto
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
