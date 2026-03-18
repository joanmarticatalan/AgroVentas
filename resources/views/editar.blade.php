<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
</head>
<body>
    <header>
        <a href="{{ route('carrito.all') }}">CARRITO</a>
        <a href="{{ route('perfil.editar') }}">MI PERFIL</a>
        <a href="{{ route('pedidos.usuario') }}">MIS PEDIDOS</a>
        
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

    
    <form action="{{ route('editar.producto', $producto->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') 

        <div>
            <label>Nombre del Producto:</label>
            <input type="text" name="nombre" value="{{ old('nombre', $producto->nombre) }}" required>
        </div>

        <div>
            <label>Variedad:</label>
            <input type="text" name="variedad" value="{{ old('variedad', $producto->variedad) }}">
        </div>

        <div>
            <label>Stock:</label>
            <input type="number" name="stock" min="0" value="{{ old('stock', $producto->stock) }}" required>
        </div>

        <div>
            <label>Fecha de Producción:</label>
            <input type="date" name="fecha" value="{{ old('fecha', $producto->fechaProduccion) }}" required>
        </div>

        <div>
            <label>Precio (€):</label>
            <input type="number" step="0.01" name="precio" value="{{ old('precio', $producto->precio) }}" required>
        </div>

        <div>
            <label>Ubicación:</label>
            <select name="localizacion_id" required>
                <option value="">Seleccione una localización</option>
                @foreach($localizaciones as $loc)
                    <option value="{{ $loc->id }}" 
                        {{ old('localizacion_id', $producto->localizacion_id) == $loc->id ? 'selected' : '' }}>
                        {{ $loc->nombreCalle }}, {{ $loc->numero }} ({{ $loc->provincia }})
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label>Imagen actual:</label><br>
            @if($producto->imagen)
                <img src="{{ asset('storage/' . $producto->imagen) }}" alt="Imagen actual" width="150">
            @endif
        </div>

        <div>
            <label>Nueva imagen (opcional):</label>
            <input type="file" name="imagen" accept="image/*">
            <small>Si no seleccionas ninguna, se conservará la imagen actual.</small>
        </div>

        <button type="submit">Actualizar Producto</button>
    </form>
</body>
</html>