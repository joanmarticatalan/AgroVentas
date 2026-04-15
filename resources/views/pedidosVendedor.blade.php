<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    @if(session('success'))
        <div style="padding: 12px; margin: 16px 0; border: 1px solid #198754; background: #d1e7dd; color: #0f5132;">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="padding: 12px; margin: 16px 0; border: 1px solid #842029; background: #f8d7da; color: #842029;">
            {{ session('error') }}
        </div>
    @endif
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
    <h1>Pedidos del vendedor</h1>
    <ul>
        @foreach($pedidos as $pedido)
            <li>
                Pedido #{{ $pedido->id }} - Cliente: {{ $pedido->cliente->name ?? 'Desconocido' }} - Estado: {{ $pedido->estado }} - Total: {{ $pedido->precio_total }}
                <ul>
                    @foreach($pedido->productos as $producto)
                        <li>{{ $producto->nombre }} - Cantidad: {{ $producto->pivot->cantidad }}</li>
                    @endforeach
                </ul>

                @if($pedido->estado === \App\Models\Pedido::ESTADO_EN_CURSO)
                    <form method="POST" action="{{ route('pedidos.estado.update', $pedido) }}">
                        @csrf
                        @method('PATCH')
                        @if($pedido->tipoEnvio === 'EnvioCasa')
                            <input type="hidden" name="estado" value="{{ \App\Models\Pedido::ESTADO_ENVIADO }}">
                            <button type="submit">Marcar como enviado</button>
                        @elseif($pedido->tipoEnvio === 'A recoger')
                            <input type="hidden" name="estado" value="{{ \App\Models\Pedido::ESTADO_LISTO_RECOGER }}">
                            <button type="submit">Marcar como listo para recoger</button>
                        @endif
                    </form>
                @endif
            </li>
        @endforeach
    </ul>
</body>
</html>
