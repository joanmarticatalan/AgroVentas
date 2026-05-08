@extends('layouts.agro-shell')

@section('title', 'Mi perfil - AgroVentas')
@section('body_class', 'flex flex-col text-agro-text')
@section('content')
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
@endsection
