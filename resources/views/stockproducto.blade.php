<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
        
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
                </tr>
            @endforeach
        </tbody>
    </table>
    <!-- AQUI HAY QUE PONER EL STOCK DE LOS PRODUCTOS PARA QUE EL VENDEDOR LO PUEDA VER -->
</body>
</html>