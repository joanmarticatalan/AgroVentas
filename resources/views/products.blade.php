<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <header>
        <a href="/carro">CARRITO</a>
        <a href="">MI PERFIL</a>
        <a href="todos.pedidos">MIS PEDIDOS</a>
        <a href="logout">LOG OUT</a>
<!-- PONER IF PARA SI ERES VENDEDOR-->
        <a href="">STOCK PRODUCTOS</a>
        <a href="">PEDIDOS</a>
<!-- PONER IF PARA SI ERES ADMIN-->
        <a href="">GESTION USUARIOS</a>

    </header>
    <ul>
        <?php foreach ($products as $prod):?>
            <a href="/infoProducto/<?php echo $prod->id ?>"><li><?php echo $prod->nombre?></a>  y su vededor =        
                <?php foreach ($usuarios as $vendedor):?>
                    <?php if($vendedor->id===$prod->user_id): ?>
                        <?php echo $vendedor->name;?>
                    <?php endif?>
                <?php endforeach?>
             </li>
        <?php endforeach?>
     </ul>
</body>
</html>