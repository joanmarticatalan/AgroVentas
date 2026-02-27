<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Pedidos del vendedor</h1>
    <ul>
        @foreach($pedidos as $pedido)
            <li>
                Pedido #{{ $pedido->id }} - Cliente: {{ $pedido->cliente->name ?? 'Desconocido' }} - Total: {{ $pedido->total }} 
                <ul>
                    @foreach($pedido->productos as $line)
                        <li>{{ $line->name }} - Cantidad: {{ $line->pivot->cantidad }}</li>
                    @endforeach
                </ul>
            </li>
        @endforeach
    </ul>
</body>
</html>