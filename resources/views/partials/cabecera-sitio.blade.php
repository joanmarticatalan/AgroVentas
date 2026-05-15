@php
    $esVendedor = auth()->check() && in_array(auth()->user()->tipoCliente, ['vendedor', 'compraventa'], true);
    $esAdmin = auth()->check() && auth()->user()->tipoCliente === 'admin';
@endphp

<header class="sitio-nav">
    <div class="mx-auto flex max-w-7xl flex-col gap-4 px-6 py-4 lg:flex-row lg:items-center lg:justify-between">
        <div class="flex items-center justify-between gap-4">
            <a href="{{ route('inicio') }}" class="sitio-marca text-3xl font-bold text-white">Agro<span class="sitio-marca-acento">Ventas</span></a>
            <a href="{{ route('carrito.all') }}" @class(['sitio-enlace text-sm lg:hidden', 'sitio-enlace-activo' => request()->routeIs('carrito.all', 'checkout', 'checkout.confirm')])>Carrito</a>
        </div>

        <nav class="flex flex-wrap items-center gap-x-5 gap-y-2 text-sm lg:text-base">
            <a href="{{ route('inicio') }}" @class(['sitio-enlace', 'sitio-enlace-activo' => request()->routeIs('inicio')])>Inicio</a>
            <a href="{{ route('todos.productos') }}" @class(['sitio-enlace', 'sitio-enlace-activo' => request()->routeIs('todos.productos', 'ver.producto')])>Productos</a>
            @auth
                <a href="{{ route('pedidos.usuario') }}" @class(['sitio-enlace', 'sitio-enlace-activo' => request()->routeIs('pedidos.usuario')])>Mis pedidos</a>
                @if($esVendedor)
                    <a href="{{ route('mis.productos') }}" @class(['sitio-enlace', 'sitio-enlace-activo' => request()->routeIs('mis.productos', 'productos.edit', 'editar.producto')])>Mis productos</a>
                    <a href="{{ route('pedidos.vendedor') }}" @class(['sitio-enlace', 'sitio-enlace-activo' => request()->routeIs('pedidos.vendedor', 'pedidos.estado.update')])>Pedidos</a>
                    <a href="{{ route('pg.anadir.producto') }}" @class(['sitio-enlace', 'sitio-enlace-activo' => request()->routeIs('pg.anadir.producto')])>Añadir producto</a>
                @endif
                @if($esAdmin)
                    <a href="{{ route('users.index') }}" @class(['sitio-enlace', 'sitio-enlace-activo' => request()->routeIs('users.*')])>Gestión usuarios</a>
                @endif
            @endauth
        </nav>

        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('carrito.all') }}" @class(['sitio-enlace hidden lg:inline-flex', 'sitio-enlace-activo' => request()->routeIs('carrito.all', 'checkout', 'checkout.confirm')])>Carrito</a>
            @auth
                <a href="{{ route('perfil.editar') }}" @class(['sitio-boton sitio-boton-contorno px-4 py-2 text-sm', 'sitio-enlace-activo' => request()->routeIs('perfil.editar')])>Mi perfil</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="sitio-boton sitio-boton-primario px-4 py-2 text-sm">Salir</button>
                </form>
            @else
                <a href="{{ route('login') }}" @class(['sitio-enlace', 'sitio-enlace-activo' => request()->routeIs('login')])>Iniciar sesión</a>
                <a href="{{ route('register') }}" class="sitio-boton sitio-boton-primario px-4 py-2 text-sm">Registrarse</a>
            @endauth
        </div>
    </div>
</header>
