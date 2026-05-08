@php
    $isSeller = auth()->check() && in_array(auth()->user()->tipoCliente, ['vendedor', 'compraventa'], true);
    $isAdmin = auth()->check() && auth()->user()->tipoCliente === 'admin';
@endphp

<header class="site-nav">
    <div class="mx-auto flex max-w-7xl flex-col gap-4 px-6 py-4 lg:flex-row lg:items-center lg:justify-between">
        <div class="flex items-center justify-between gap-4">
            <a href="{{ route('inicio') }}" class="site-brand text-3xl font-bold text-white">Agro<span class="site-brand-accent">Ventas</span></a>
            <a href="{{ route('carrito.all') }}" class="site-link text-sm lg:hidden">Carrito</a>
        </div>

        <nav class="flex flex-wrap items-center gap-x-5 gap-y-2 text-sm lg:text-base">
            <a href="{{ route('inicio') }}" @class(['site-link', 'site-link-active' => request()->routeIs('inicio')])>Inicio</a>
            <a href="{{ route('todos.productos') }}" @class(['site-link', 'site-link-active' => request()->routeIs('todos.productos', 'ver.producto')])>Productos</a>
            @auth
                <a href="{{ route('pedidos.usuario') }}" @class(['site-link', 'site-link-active' => request()->routeIs('pedidos.usuario')])>Mis pedidos</a>
                @if($isSeller)
                    <a href="{{ route('mis.productos') }}" @class(['site-link', 'site-link-active' => request()->routeIs('mis.productos', 'productos.edit', 'editar.producto')])>Mis productos</a>
                    <a href="{{ route('pedidos.vendedor') }}" @class(['site-link', 'site-link-active' => request()->routeIs('pedidos.vendedor', 'pedidos.estado.update')])>Pedidos</a>
                    <a href="{{ route('pg.anadir.producto') }}" @class(['site-link', 'site-link-active' => request()->routeIs('pg.anadir.producto')])>Añadir producto</a>
                @endif
                @if($isAdmin)
                    <a href="{{ route('users.index') }}" @class(['site-link', 'site-link-active' => request()->routeIs('users.*')])>Gestión usuarios</a>
                @endif
            @endauth
        </nav>

        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('carrito.all') }}" class="site-link hidden lg:inline-flex">Carrito</a>
            @auth
                <a href="{{ route('perfil.editar') }}" @class(['site-button site-button-ghost px-4 py-2 text-sm', 'site-link-active' => request()->routeIs('perfil.editar')])>Mi perfil</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="site-button site-button-primary px-4 py-2 text-sm">Salir</button>
                </form>
            @else
                <a href="{{ route('login') }}" @class(['site-link', 'site-link-active' => request()->routeIs('login')])>Iniciar sesión</a>
                <a href="{{ route('register') }}" class="site-button site-button-primary px-4 py-2 text-sm">Registrarse</a>
            @endauth
        </div>
    </div>
</header>
