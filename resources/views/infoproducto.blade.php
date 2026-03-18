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

    <!-- AQUI SALDRA LA INFORMACIÓN QUE TIENE CADA PRODUCTO Y EL VENDEDOR 
     (DESDE AQUI SE PUEDE AÑADIR AL CARRO TAMBIEN) -->
     <?php echo $producto->nombre ?>
    <div >
        <div>
            <span>Variedad</span>
            <p><?php echo $producto->variedad ?></p>
        </div>
        <div>
            <span >Precio</span>
            <p ><?php echo $producto->precio ?>€</p>
        </div>
        <div>
            <span >Vendedor</span>
            <p ><?php echo $user->name ?></p>
        </div>
        <div>
            <span >Fecha de producción</span>
            <p ><?php echo $producto->fechaProduccion ?></p>
        </div>
        <div>
            <span >Imagen</span>
            <!--<?php echo $user->name ?>-->
        </div>
    </div>
    <div>
        <form action="/carrito/agregar/<?php echo $producto->id ?>" method="POST">
        @csrf
            <button type="submit">
                Añadir al carrito
            </button>
        </form>

        <a href="{{ route('todos.productos') }}">
            Volver al listado
        </a>
    </div>

</body>
</html>