<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
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