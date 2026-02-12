<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
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
            <label>Stock:</label>
            <input type="number" name="stock" min="0" required>
        </div>

        <div>
            <label>Fecha de Producción:</label>
            <input type="date" name="fecha" required>
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