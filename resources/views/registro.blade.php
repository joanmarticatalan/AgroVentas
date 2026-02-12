<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="{{ route('register') }}" method="POST">
    @csrf
    <input type="text" name="name" placeholder="Nombre completo" required>
    <input type="email" name="email" placeholder="Correo electrónico" required>
    <input type="password" name="password" placeholder="Contraseña" required>
    <input type="password" name="password_confirmation" placeholder="Repetir contraseña" required>
    
    <input type="text" name="telefono" placeholder="Teléfono" required>
    
    <select name="rol" id="rol">
                <option value=""></option>
                <option value="comprador">Comprador</option>
                <option value="vendedor">Vendedor</option>
                <option value="compraVenta">Compra-Venta</option>
            </select>

    <select name="localizacion_id">
        @foreach($localizaciones as $loc)
            <option value="{{ $loc->id }}">{{ $loc->nombre_ciudad }}</option>
        @endforeach
    </select>

    <button type="submit">Registrarse</button>
</form>
</body>
</html>