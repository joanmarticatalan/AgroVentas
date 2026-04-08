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
    @if(session('success'))
        <div style="padding: 12px; margin: 16px 0; border: 1px solid #198754; background: #d1e7dd; color: #0f5132;">
            {{ session('success') }}
        </div>
    @endif
    <h1>Pedidos del vendedor

    <table border="1">
    <thead>
        <tr>
            <th>ID Pedido</th>
            <th>Usuario</th>
            <th>Fecha</th>
            <th>Tipo de Envío</th>
            <th>Productos (Cant. x Nombre)</th>
            <th>Precio Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($pedidos as $pedido)
            <tr>
                <td>{{ $pedido->id }}</td>
                <td>{{ $usuario->name }}</td>
                <td>{{ $pedido->fecha }}</td>
                <td>{{ $pedido->tipoEnvio }}</td>
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
