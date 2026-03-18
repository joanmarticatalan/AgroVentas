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