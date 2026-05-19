@extends('layouts.estructura-agro')

@section('title', 'Crear usuario - AgroVentas')
@section('body_class', 'flex flex-col text-agro-text')
@section('content')
    <main class="flex-1">
        <section class="max-w-5xl mx-auto px-6 py-10 lg:py-12">
            <div class="grid gap-8 lg:grid-cols-[0.9fr_1.1fr]">
                <div class="space-y-5">
                    <p class="text-sm font-semibold uppercase tracking-[0.22em] text-agro-brown">Administración</p>
                    <h1 class="text-4xl font-black tracking-tight text-agro-primary">Crear usuario</h1>
                    <p class="text-lg leading-8 text-slate-600">Da de alta cuentas nuevas con rol, datos de contacto y localización desde el panel de administración.</p>
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

                    <form method="POST" action="{{ route('users.store') }}" class="mt-6 space-y-6">
                        @csrf
                        <div class="grid gap-6 sm:grid-cols-2">
                            <div class="sm:col-span-2">
                                <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">Nombre</label>
                                <input id="name" name="name" type="text" value="{{ old('name') }}" required class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none transition focus:border-agro-primary focus:bg-white">
                            </div>
                            <div class="sm:col-span-2">
                                <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">Email</label>
                                <input id="email" name="email" type="email" value="{{ old('email') }}" required class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none transition focus:border-agro-primary focus:bg-white">
                            </div>
                            <div>
                                <label for="telefono" class="mb-2 block text-sm font-semibold text-slate-700">Teléfono</label>
                                <input id="telefono" name="telefono" type="text" value="{{ old('telefono') }}" required class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none transition focus:border-agro-primary focus:bg-white">
                            </div>
                            <div>
                                <label for="tipoCliente" class="mb-2 block text-sm font-semibold text-slate-700">Rol</label>
                                <select id="tipoCliente" name="tipoCliente" required class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none transition focus:border-agro-primary focus:bg-white">
                                    <option value="">Selecciona un rol</option>
                                    @foreach(['comprador', 'vendedor', 'compraventa', 'admin'] as $rol)
                                        <option value="{{ $rol }}" @selected(old('tipoCliente') === $rol)>{{ ucfirst($rol) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="password" class="mb-2 block text-sm font-semibold text-slate-700">Contraseña</label>
                                <input id="password" name="password" type="password" required class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none transition focus:border-agro-primary focus:bg-white">
                            </div>
                            <div>
                                <label for="password_confirmation" class="mb-2 block text-sm font-semibold text-slate-700">Confirmar contraseña</label>
                                <input id="password_confirmation" name="password_confirmation" type="password" required class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none transition focus:border-agro-primary focus:bg-white">
                            </div>
                            <div class="sm:col-span-2">
                                <label for="localizacion_id" class="mb-2 block text-sm font-semibold text-slate-700">Localización</label>
                                <select id="localizacion_id" name="localizacion_id" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none transition focus:border-agro-primary focus:bg-white">
                                    <option value="">Sin localización</option>
                                    @foreach($localizaciones as $localizacion)
                                        <option value="{{ $localizacion->id }}" @selected(old('localizacion_id') == $localizacion->id)>
                                            {{ $localizacion->nombreCalle }}, {{ $localizacion->numero }} ({{ $localizacion->provincia }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="flex flex-col gap-3 sm:flex-row">
                            <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-agro-accent px-6 py-3 text-base font-semibold text-white transition hover:bg-orange-600">Guardar usuario</button>
                            <a href="{{ route('users.index') }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-300 px-6 py-3 text-base font-semibold text-slate-700 transition hover:border-agro-primary hover:text-agro-primary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
@endsection
