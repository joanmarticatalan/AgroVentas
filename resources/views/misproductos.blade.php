<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <header>
        <a href="{{ route('carrito.all') }}">CARRITO</a>
        <a href="{{ route('perfil.editar') }}">MI PERFIL</a>
        <a href="{{ route('pedidos.usuario') }}">MIS PEDIDOS</a>
        <a href="{{ route('todos.productos') }}">PRODUCTOS</a>
        
        {{-- Logout con POST --}}
        <form method="POST" action="{{ route('logout') }}" style="display:inline;">
            @csrf
            <button type="submit">LOG OUT</button>
        </form>

        {{-- Opciones para vendedor --}}
        @auth
            @if(auth()->user()->tipoCliente === 'vendedor' || auth()->user()->tipoCliente === 'compraventa')
                <a href="{{ route('mis.productos') }}">MIS PRODUCTOS</a>
                <a href="{{ route('pedidos.vendedor') }}">PEDIDOS</a>
                <a href="{{ route('pg.anadir.producto') }}">AÑADIR PRODUCTO</a>
            @endif

            {{-- Opciones para admin --}}
            @if(auth()->user()->tipoCliente === 'admin')
                <a href="{{ route('users.index') }}">GESTION USUARIOS</a>
            @endif
        @endauth
    </header>
    MIS PRODUCTOS
    <a href="{{ route('pg.anadir.producto') }}">Crear nuevo producto</a>
    <table border="1">
        <thead>
            <tr>
                <th>Imagen</th>
                <th>Producto</th>
                <th>Variedad</th>
                <th>Origen (Localización)</th>
                <th>Fecha Producción</th>
                <th>Stock Actual</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productos as $producto)
                <tr>
                    <td>
                        @if($producto->imagen)
                            <img src="{{ asset('storage/' . $producto->imagen) }}" alt="{{ $producto->nombre }}" width="50">
                        @else
                            <span>Sin imagen</span>
                        @endif
                    </td>

                    <td>{{ $producto->nombre }}</td>
                    <td>{{ $producto->variedad }}</td>
                    <td>{{ $producto->localizacion->nombre ?? 'No asignada' }}</td>
                    <td>{{ $producto->fechaProduccion }}</td>

                    <td style="text-align: center; font-weight: bold;">
                        {{ $producto->stock }} unidades
                    </td>

                    <td>
                        @if($producto->stock <= 0)
                            <span style="color: red; font-weight: bold;">AGOTADO</span>
                        @elseif($producto->stock <= 10)
                            <span style="color: orange; font-weight: bold;">¡ULTIMAS UNIDADES!</span>
                        @else
                            <span style="color: green;">Disponible</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('productos.edit', $producto->id) }}">Editar producto</a>
                        <form action="{{ route('borrar.producto', $producto->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('¿Estás seguro de que deseas eliminar este producto?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <!-- AQUI HAY QUE PONER EL STOCK DE LOS PRODUCTOS PARA QUE EL VENDEDOR LO PUEDA VER -->
</body>
</html>