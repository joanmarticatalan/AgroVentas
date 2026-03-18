<div>
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
    <h1>Tu Carrito de Compra</h1>
    <a href="/products">volver</a>
    <div>
        <?php if($carro): ?>
            <?php $total = 0; ?>
            
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Precio/u</th>
                        <th>Cantidad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($carro as $obj): ?>
                        <tr>
                            <td><strong>{{$obj['name']}}</strong></td>
                            <td>{{$obj['price']}}€</td>
                            <td>
                                {{$obj['quantity']}}
                            </td>
                            <td>
                                <form action="/carrito/agregar/<?php echo $obj['id'] ?>" method="post">
                                    @csrf 
                                    <button type="submit">+1</button>
                                </form>
                                <form action="/carrito/borrar/<?php echo $obj['id'] ?>" method="post">
                                    @csrf 
                                    <button type="submit">-1</button>
                                </form>
                            </td>
                        </tr>
                        <?php $total = $total + $obj['price'] * $obj['quantity']; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <hr>
            
            <div>
                <p>
                    <a href="/carrito/borrarTodo">Vaciar todo el carrito</a>
                </p>
                
                <h3>
                    <?php echo "Total: " . $total . "€" ?>
                </h3>

                
                <form action="{{ route('todos.productos') }}" method="POST">
                    @csrf
                    <button type="submit">Confirmar y Pagar</button>
                </form>
            </div>

        <?php else: ?>
            <div>
                <p>¡No tienes nada en el carrito!</p>
                <a href="{{ route('todos.productos') }}">Volver a la tienda</a>
            </div>
        <?php endif; ?>                
    </div>
</div>