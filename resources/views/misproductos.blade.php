@extends('layouts.estructura-agro')

@section('title', 'Mis productos - AgroVentas')
@section('body_class', 'flex flex-col text-agro-text')
@section('content')

    <main class="flex-grow max-w-7xl mx-auto w-full px-6 py-12">

        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-bold text-agro-primary">Mis productos</h1>
            <a href="{{ route('pg.anadir.producto') }}"
               class="bg-agro-accent hover:bg-orange-600 text-white text-lg font-semibold px-6 py-3 rounded-xl transition-colors">
                + Crear nuevo producto
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-agro-primary text-white">
                    <tr>
                        <th class="px-5 py-4 font-semibold">Imagen</th>
                        <th class="px-5 py-4 font-semibold">Producto</th>
                        <th class="px-5 py-4 font-semibold">Variedad</th>
                        <th class="px-5 py-4 font-semibold">Origen</th>
                        <th class="px-5 py-4 font-semibold">Fecha producción</th>
                        <th class="px-5 py-4 font-semibold text-center">Stock</th>
                        <th class="px-5 py-4 font-semibold text-center">Estado</th>
                        <th class="px-5 py-4 font-semibold text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($productos as $producto)
                        <tr class="hover:bg-gray-50 transition-colors">

                            <td class="px-5 py-4">
                                @if($producto->imagen)
                                    <img src="{{ asset('storage/' . $producto->imagen) }}"
                                         alt="{{ $producto->nombre }}"
                                         class="w-16 h-16 object-cover rounded-lg">
                                @else
                                    <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center text-agro-muted text-sm">
                                        Sin imagen
                                    </div>
                                @endif
                            </td>

                            <td class="px-5 py-4 font-semibold">{{ $producto->nombre }}</td>
                            <td class="px-5 py-4 text-agro-muted">{{ $producto->variedad }}</td>
                            <td class="px-5 py-4 text-agro-muted">{{ $producto->localizacion->nombreCalle ?? 'No asignada' }}</td>
                            <td class="px-5 py-4 text-agro-muted">{{ $producto->fechaProduccion }}</td>

                            <td class="px-5 py-4 text-center font-bold">
                                {{ $producto->stock }} uds.
                            </td>

                            <td class="px-5 py-4 text-center">
                                @if($producto->stock <= 0)
                                    <span class="bg-red-100 text-red-700 font-semibold px-3 py-1 rounded-full text-base">Agotado</span>
                                @elseif($producto->stock <= 10)
                                    <span class="bg-orange-100 text-orange-700 font-semibold px-3 py-1 rounded-full text-base">Últimas unidades</span>
                                @else
                                    <span class="bg-green-100 text-green-700 font-semibold px-3 py-1 rounded-full text-base">Disponible</span>
                                @endif
                            </td>

                            <td class="px-5 py-4 text-center">
                                <div class="flex items-center justify-center gap-3">
                                    <a href="{{ route('productos.edit', $producto->id) }}"
                                       class="bg-agro-primary hover:bg-agro-secondary text-white font-semibold px-4 py-2 rounded-lg transition-colors">
                                        Editar
                                    </a>
                                    <form action="{{ route('borrar.producto', $producto->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                onclick="return confirm('¿Estás seguro de que deseas eliminar este producto?')"
                                                class="bg-red-500 hover:bg-red-600 text-white font-semibold px-4 py-2 rounded-lg transition-colors">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </main>
@endsection
