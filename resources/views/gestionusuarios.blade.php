@extends('layouts.estructura-agro')

@section('title', 'Administración - AgroVentas')
@section('body_class', 'flex flex-col text-agro-text')
@section('content')

    <main class="flex-1">
        <section class="max-w-7xl mx-auto px-6 py-10 lg:py-12">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.22em] text-agro-brown">Panel de administración</p>
                    <h1 class="mt-2 text-4xl font-black tracking-tight text-agro-primary sm:text-5xl">Gestión de usuarios</h1>
                    <p class="mt-3 max-w-3xl text-lg leading-8 text-slate-600">
                        Controla altas, permisos y datos básicos de cuenta desde un panel centralizado para el rol administrador.
                    </p>
                </div>

                <div class="flex flex-col gap-3 sm:flex-row">
                    <a href="{{ route('users.create') }}" class="inline-flex items-center justify-center rounded-2xl bg-agro-accent px-6 py-3 text-base font-semibold text-white transition hover:bg-orange-600">
                        Crear usuario
                    </a>
                    <a href="{{ route('todos.productos') }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-300 px-6 py-3 text-base font-semibold text-slate-700 transition hover:border-agro-primary hover:text-agro-primary">
                        Ver catálogo
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="mt-6 rounded-2xl border border-green-200 bg-green-50 px-5 py-4 text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mt-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            <div class="mt-8 grid gap-4 md:grid-cols-2 xl:grid-cols-5">
                <article class="rounded-[1.75rem] bg-white p-5 shadow-lg shadow-agro-primary/5 ring-1 ring-agro-primary/10">
                    <p class="text-sm font-semibold uppercase tracking-[0.18em] text-agro-brown">Usuarios</p>
                    <p class="mt-3 text-3xl font-black text-agro-primary">{{ $resumen['usuarios'] }}</p>
                </article>
                <article class="rounded-[1.75rem] bg-white p-5 shadow-lg shadow-agro-primary/5 ring-1 ring-agro-primary/10">
                    <p class="text-sm font-semibold uppercase tracking-[0.18em] text-agro-brown">Admins</p>
                    <p class="mt-3 text-3xl font-black text-agro-primary">{{ $resumen['admins'] }}</p>
                </article>
                <article class="rounded-[1.75rem] bg-white p-5 shadow-lg shadow-agro-primary/5 ring-1 ring-agro-primary/10">
                    <p class="text-sm font-semibold uppercase tracking-[0.18em] text-agro-brown">Vendedores</p>
                    <p class="mt-3 text-3xl font-black text-agro-primary">{{ $resumen['vendedores'] }}</p>
                </article>
                <article class="rounded-[1.75rem] bg-white p-5 shadow-lg shadow-agro-primary/5 ring-1 ring-agro-primary/10">
                    <p class="text-sm font-semibold uppercase tracking-[0.18em] text-agro-brown">Productos</p>
                    <p class="mt-3 text-3xl font-black text-agro-primary">{{ $resumen['productos'] }}</p>
                </article>
                <article class="rounded-[1.75rem] bg-white p-5 shadow-lg shadow-agro-primary/5 ring-1 ring-agro-primary/10">
                    <p class="text-sm font-semibold uppercase tracking-[0.18em] text-agro-brown">Pedidos</p>
                    <p class="mt-3 text-3xl font-black text-agro-primary">{{ $resumen['pedidos'] }}</p>
                </article>
            </div>

            <div class="mt-8 overflow-hidden rounded-[2rem] bg-white shadow-xl shadow-agro-primary/10 ring-1 ring-agro-primary/10">
                <div class="flex flex-col gap-3 border-b border-slate-200 px-6 py-5 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.18em] text-agro-brown">Base de usuarios</p>
                        <h2 class="mt-1 text-2xl font-bold text-agro-primary">Listado completo</h2>
                    </div>
                    <p class="text-sm text-slate-500">Últimos registros primero. Roles y localizaciones visibles de un vistazo.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 text-left">
                        <thead class="bg-slate-50">
                            <tr class="text-sm uppercase tracking-[0.14em] text-slate-500">
                                <th class="px-6 py-4 font-semibold">Usuario</th>
                                <th class="px-6 py-4 font-semibold">Contacto</th>
                                <th class="px-6 py-4 font-semibold">Rol</th>
                                <th class="px-6 py-4 font-semibold">Localización</th>
                                <th class="px-6 py-4 font-semibold">Alta</th>
                                <th class="px-6 py-4 font-semibold text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($usuarios as $usuario)
                                <tr class="hover:bg-slate-50/80">
                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-slate-900">{{ $usuario->name }}</div>
                                        <div class="text-sm text-slate-500">#{{ $usuario->id }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-600">
                                        <div>{{ $usuario->email }}</div>
                                        <div>{{ $usuario->telefono }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex rounded-full px-3 py-1 text-sm font-semibold
                                            @class([
                                                'bg-red-100 text-red-700' => $usuario->tipoCliente === 'admin',
                                                'bg-green-100 text-green-700' => in_array($usuario->tipoCliente, ['vendedor', 'compraventa'], true),
                                                'bg-slate-100 text-slate-700' => $usuario->tipoCliente === 'comprador',
                                            ])">
                                            {{ $usuario->tipoCliente }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-600">
                                        @if($usuario->localizacion)
                                            {{ $usuario->localizacion->nombreCalle }}, {{ $usuario->localizacion->numero }} ({{ $usuario->localizacion->provincia }})
                                        @else
                                            Sin ubicación
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-600">
                                        {{ optional($usuario->created_at)->format('d/m/Y') ?? 'Sin fecha' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-wrap justify-end gap-2">
                                            <a href="{{ route('users.show', $usuario) }}" class="inline-flex items-center justify-center rounded-xl border border-slate-300 px-3 py-2 text-sm font-semibold text-slate-700 transition hover:border-agro-primary hover:text-agro-primary">
                                                Ver
                                            </a>
                                            <a href="{{ route('users.edit', $usuario) }}" class="inline-flex items-center justify-center rounded-xl bg-agro-primary px-3 py-2 text-sm font-semibold text-white transition hover:bg-agro-secondary">
                                                Editar
                                            </a>
                                            <form method="POST" action="{{ route('users.destroy', $usuario) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('¿Seguro que quieres eliminar este usuario?')" class="inline-flex items-center justify-center rounded-xl bg-red-500 px-3 py-2 text-sm font-semibold text-white transition hover:bg-red-600">
                                                    Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-10 text-center text-slate-500">No hay usuarios registrados todavía.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </main>
@endsection
