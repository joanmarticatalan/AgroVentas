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
            <th>ID Pedido</th>
            <th>Usuario</th>
            <th>Fecha</th>
            <th>Tipo de Envío</th>
            <th>Localización</th>
            <th>Productos (Cant. x Nombre)</th>
            <th>Precio Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($pedidos as $pedido)
            <tr>
                <td>{{ $pedido->id }}</td>
                <td>{{ $usuario }}</td>
                <td>{{ $pedido->fecha }}</td>
                <td>{{ $pedido->tipoEnvio }}</td>
                <td>{{ $pedido->localizacion->nombre ?? 'Sin ubicación' }}</td>
                <td>
                    <ul>
                        @foreach($pedido->productos as $producto)
                            <li>
                                {{ $producto->pivot->cantidad }}x {{ $producto->nombre }}
                            </li>
                        @endforeach
                    </ul>
                </td>
                <td>{{ $pedido->precio_total }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
    <!-- AQUI HAY QUE PONER TODOS LOS PEDIDOS QUE TE HAN ENTRADO COMO VENDEDOR
      Y PODER PONERLOS COMO ENVIADOS O COMO LISTOS PARA RECOGER -->
</body>
</html>