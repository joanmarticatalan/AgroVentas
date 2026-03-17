<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    MI PERFIL
    <a href="{{ route('todos.productos') }}">Volver</a>
    <div>
        <label for="">
                Nombre:
        </label>
        <input type="text" name="" id="">
    </div>
    <div>
        <label for="">
                Email::
        </label>
        <input type="email" name="" id="">
    </div>
    <div>
        <section>
            <label for="">
                    Localización:
            </label>
            <select name="" id="">
                @foreach($localizaciones as $localizacion)
                    <option value="{{ $user->localizacion_id }}" {{ $user->localizacion_id == $localizacion->id ? 'selected' : '' }}>
                        {{ $localizacion->nombre }}
                    </option>
                @endforeach
            </select>
        </section>
    </div>
    <div>
        <section>
            <label for="">
                Tipo de cliente:
            </label>
            <select name="" id="">
                <option value="vendedor">Vendedor</option>
                <option value="comprador">Comprador</option>
                <option value="compraventa">Compra-venta</option>
            </select>
        </section>
    </div>

    <!-- AQUI HAY QUE PONER LOS DATOS DEL PERFIL Y QUE SE PUEDAN CAMBIAR -->
</body>
</html>