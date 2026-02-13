<div>
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