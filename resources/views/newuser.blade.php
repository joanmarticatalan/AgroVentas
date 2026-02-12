<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <header>
        <div>
            <img src="" alt="Logo">
            <div>
                <ul>
                    <li><a href="">Inicio</a></li>
                    <li><a href="">Productos</a></li>
                    <li><a href="">Perfil</a></li>
                </ul>
            </div>
            <div>
                <a href="">Carrito</a>
                <a href="/login">Iniciar Sesión</a>
                <a href="/newuser">Registrarse</a>
            </div>
        </div>
    </header>
    <main>
    <div>
        <form action="" method="post"><!-- Falta posar la action -->
            <label for="name">Nombre Completo</label><br>
            <input type="text" name="name"><br><br>
            <label for="username">Nombre de Ususario</label><br>
            <input type="text" name="username"><br><br>
            <label for="email">Email</label><br>
            <input type="email" name="email"><br><br>
            <label for="password">Contraseña</label><br>
            <input type="password" name="password"><br><br>
            <label for="rol">Que vas a ser?</label>
            <select name="rol" id="rol">
                <option value=""></option>
                <option value="comprador">Comprador</option>
                <option value="vendedor">Vendedor</option>
                <option value="compraVenta">Compra-Venta</option>
            </select><br><br>
            <input type="submit" value="Crear Usuario">
        </form>
    </div>
    </main>
    <footer>
        
    </footer>
</body>
</html>
