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
    @if ($errors->any())
    <div style="background: #ffcccc; color: red; padding: 10px;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <main>
        <form action="" method="post">
            @csrf
            <input type="email" name="email" placeholder="Correo electrónico" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <div>
                <input type="submit" value="Enviar">
                <a href="">Crear cuenta</a>
            </div>
        </form>
    </main>
    <footer>
        
    </footer>

</body>
</html>