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
    <form action="{{ route('subir.producto') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div>
            <label>Nombre del Producto:</label>
            <input type="text" name="nombre" required>
        </div>

        <div>
            <label>Variedad:</label>
            <input type="text" name="variedad">
        </div>

        <div>
            <label>Stock (kg):</label>
            <input type="number" name="stock" min="0" required>
        </div>

        <div>
            <label>Fecha de Producción:</label>
            <input type="date" name="fecha" required>
        </div>

        <div>
            <label>Precio (€/kg):</label>
            <input type="number" step="0.01" name="precio" required>
        </div>

        <div>
            <label>Ubicación:</label>
            <select name="localizacion_id" required>
                <option value="">Seleccione una localización</option>
                @foreach($localizaciones as $loc)
                    <option value="{{ $loc->id }}">
                        {{ $loc->nombreCalle }}, {{ $loc->numero }} ({{ $loc->provincia }})
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label>Imagen del producto:</label>
            <input type="file" name="imagen" accept="image/*">
        </div>

        <button type="submit">Crear Producto</button>
    </form>
</body>
</html>