<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis pedidos - AgroVentas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-agro-bg text-slate-900">
    @php
        $totalPedidos = $pedidos->count();
        $pedidosActivos = $pedidos->where('estado', \App\Models\Pedido::ESTADO_EN_CURSO)->count();
        $importeAcumulado = $pedidos->sum('precio_total');
        $estados = [
            \App\Models\Pedido::ESTADO_EN_CURSO => ['label' => 'En curso', 'classes' => 'bg-amber-100 text-amber-800 ring-amber-200'],
            \App\Models\Pedido::ESTADO_ENVIADO => ['label' => 'Enviado', 'classes' => 'bg-emerald-100 text-emerald-800 ring-emerald-200'],
            \App\Models\Pedido::ESTADO_LISTO_RECOGER => ['label' => 'Listo para recoger', 'classes' => 'bg-sky-100 text-sky-800 ring-sky-200'],
        ];
    @endphp

    <header class="bg-agro-primary shadow-md">
        <div class="mx-auto flex max-w-7xl flex-col gap-4 px-6 py-4 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex items-center justify-between gap-4">
                <a href="{{ route('inicio') }}" class="text-2xl font-bold tracking-wide text-white">AgroVentas</a>
                <a href="{{ route('carrito.all') }}" class="text-base font-medium text-white transition-colors hover:text-agro-accent lg:hidden">
                    Carrito
                </a>
            </div>

            <nav class="flex flex-wrap items-center gap-x-5 gap-y-2 text-sm font-medium lg:text-base">
                <a href="{{ route('inicio') }}" class="text-white transition-colors hover:text-agro-accent">Inicio</a>
                <a href="{{ route('todos.productos') }}" class="text-white transition-colors hover:text-agro-accent">Productos</a>
                @auth
                    <a href="{{ route('pedidos.usuario') }}" class="text-agro-accent">Mis pedidos</a>
                    @if(auth()->user()->tipoCliente === 'vendedor' || auth()->user()->tipoCliente === 'compraventa')
                        <a href="{{ route('mis.productos') }}" class="text-white transition-colors hover:text-agro-accent">Mis productos</a>
                        <a href="{{ route('pedidos.vendedor') }}" class="text-white transition-colors hover:text-agro-accent">Pedidos</a>
                        <a href="{{ route('pg.anadir.producto') }}" class="text-white transition-colors hover:text-agro-accent">Añadir producto</a>
                    @endif
                    @if(auth()->user()->tipoCliente === 'admin')
                        <a href="{{ route('users.index') }}" class="text-white transition-colors hover:text-agro-accent">Gestión usuarios</a>
                    @endif
                @endauth
            </nav>

            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('carrito.all') }}" class="hidden text-white transition-colors hover:text-agro-accent lg:inline-flex">Carrito</a>
                @auth
                    <a href="{{ route('perfil.editar') }}" class="inline-flex items-center rounded-full border border-white/20 px-4 py-2 text-sm font-semibold text-white transition hover:border-agro-accent hover:text-agro-accent">
                        Mi perfil
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="inline-flex items-center rounded-full bg-agro-accent px-4 py-2 text-sm font-semibold text-white transition hover:bg-orange-600">
                            Salir
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </header>

    <main class="pb-16">
        <section class="relative overflow-hidden border-b border-agro-primary/10 bg-gradient-to-br from-white via-[#f4efe4] to-[#e7f0df]">
            <div class="absolute inset-y-0 right-0 hidden w-1/3 bg-[radial-gradient(circle_at_top,_rgba(217,123,42,0.18),_transparent_60%)] lg:block"></div>
            <div class="mx-auto grid max-w-7xl gap-10 px-6 py-12 lg:grid-cols-[1.5fr_1fr] lg:items-end lg:py-16">
                <div class="space-y-5">
                    <span class="inline-flex rounded-full border border-agro-primary/15 bg-white/80 px-4 py-1 text-sm font-semibold uppercase tracking-[0.25em] text-agro-brown">
                        Historial de compras
                    </span>
                    <div class="space-y-4">
                        <h1 class="max-w-3xl text-4xl font-black tracking-tight text-agro-primary sm:text-5xl">
                            Mis pedidos
                        </h1>
                        <p class="max-w-2xl text-lg leading-8 text-slate-600">
                            Consulta en un solo vistazo el estado de cada compra, los productos incluidos y el importe total acumulado de tus pedidos en AgroVentas.
                        </p>
                    </div>
                </div>

                <div class="grid gap-4 sm:grid-cols-3 lg:grid-cols-1">
                    <article class="rounded-[1.75rem] bg-agro-primary px-6 py-5 text-white shadow-lg shadow-agro-primary/15">
                        <p class="text-sm uppercase tracking-[0.2em] text-white/70">Resumen de compras</p>
                        <p class="mt-3 text-3xl font-black">{{ $totalPedidos }}</p>
                        <p class="mt-2 text-sm text-white/80">{{ $totalPedidos === 1 ? 'pedido registrado' : 'pedidos registrados' }}</p>
                    </article>
                    <article class="rounded-[1.75rem] border border-agro-primary/10 bg-white px-6 py-5 shadow-sm">
                        <p class="text-sm uppercase tracking-[0.2em] text-agro-brown">Pedidos activos</p>
                        <p class="mt-3 text-3xl font-black text-agro-primary">{{ $pedidosActivos }}</p>
                        <p class="mt-2 text-sm text-slate-500">Pendientes de completar o recibir.</p>
                    </article>
                    <article class="rounded-[1.75rem] border border-agro-primary/10 bg-white px-6 py-5 shadow-sm">
                        <p class="text-sm uppercase tracking-[0.2em] text-agro-brown">Importe acumulado</p>
                        <p class="mt-3 text-3xl font-black text-agro-primary">{{ number_format((float) $importeAcumulado, 2, ',', '.') }} €</p>
                        <p class="mt-2 text-sm text-slate-500">Suma total de tus compras confirmadas.</p>
                    </article>
                </div>
            </div>
        </section>

        <section class="mx-auto max-w-7xl px-6 pt-8">
            @if(session('success'))
                <div class="mb-6 rounded-[1.5rem] border border-emerald-200 bg-emerald-50 px-5 py-4 text-emerald-800 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 rounded-[1.5rem] border border-red-200 bg-red-50 px-5 py-4 text-red-700 shadow-sm">
                    {{ session('error') }}
                </div>
            @endif

            @if($pedidos->isEmpty())
                <div class="rounded-[2rem] border border-dashed border-agro-primary/25 bg-white px-8 py-16 text-center shadow-sm">
                    <span class="inline-flex rounded-full bg-agro-bg px-4 py-1 text-sm font-semibold uppercase tracking-[0.18em] text-agro-brown">
                        Sin pedidos todavía
                    </span>
                    <h2 class="mt-5 text-3xl font-black text-agro-primary">Tu historial de compras aparecerá aquí</h2>
                    <p class="mx-auto mt-4 max-w-2xl text-lg leading-8 text-slate-600">
                        Cuando completes tu primer pedido podrás revisar el estado, la entrega y el detalle de cada producto desde esta página.
                    </p>
                    <a href="{{ route('todos.productos') }}" class="mt-8 inline-flex items-center justify-center rounded-full bg-agro-accent px-6 py-3 text-base font-semibold text-white transition hover:bg-orange-600">
                        Explorar productos
                    </a>
                </div>
            @else
                <div class="mb-6 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-agro-brown">Actividad reciente</p>
                        <h2 class="mt-1 text-3xl font-black text-agro-primary">Seguimiento claro de cada pedido</h2>
                    </div>
                    <p class="max-w-xl text-sm leading-6 text-slate-600">
                        Cada tarjeta agrupa el estado actual, el tipo de entrega y el detalle de los productos incluidos para que no tengas que abrir más pantallas.
                    </p>
                </div>

                <div class="grid gap-6">
                    @foreach($pedidos as $pedido)
                        @php
                            $estadoConfig = $estados[$pedido->estado] ?? ['label' => ucfirst(str_replace('_', ' ', (string) $pedido->estado)), 'classes' => 'bg-slate-100 text-slate-700 ring-slate-200'];
                        @endphp
                        <article class="overflow-hidden rounded-[2rem] border border-agro-primary/10 bg-white shadow-sm shadow-agro-primary/5 transition hover:-translate-y-1 hover:shadow-xl hover:shadow-agro-primary/10">
                            <div class="border-b border-agro-primary/10 bg-gradient-to-r from-agro-primary to-agro-secondary px-6 py-5 text-white">
                                <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                                    <div>
                                        <p class="text-sm font-semibold uppercase tracking-[0.22em] text-white/70">Pedido #{{ $pedido->id }}</p>
                                        <h3 class="mt-2 text-2xl font-black">Compra de {{ $usuario->name }}</h3>
                                        <p class="mt-2 text-sm text-white/80">
                                            Realizado el {{ \Carbon\Carbon::parse($pedido->fecha)->format('d/m/Y') }}
                                        </p>
                                    </div>
                                    <div class="flex flex-wrap items-center gap-3">
                                        <span class="inline-flex items-center rounded-full bg-white/15 px-4 py-2 text-sm font-semibold text-white ring-1 ring-white/15">
                                            {{ $pedido->tipoEnvio === 'EnvioCasa' ? 'Envío a domicilio' : 'Recogida en punto acordado' }}
                                        </span>
                                        <span class="inline-flex items-center rounded-full px-4 py-2 text-sm font-semibold ring-1 {{ $estadoConfig['classes'] }}">
                                            {{ $estadoConfig['label'] }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="grid gap-6 px-6 py-6 lg:grid-cols-[1.7fr_0.9fr]">
                                <div>
                                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-agro-brown">Productos incluidos</p>
                                    <div class="mt-4 grid gap-4">
                                        @foreach($pedido->productos as $producto)
                                            <div class="flex flex-col gap-3 rounded-[1.5rem] border border-slate-200 bg-slate-50 px-4 py-4 sm:flex-row sm:items-center sm:justify-between">
                                                <div>
                                                    <p class="text-lg font-bold text-agro-primary">{{ $producto->nombre }}</p>
                                                    <p class="text-sm text-slate-500">{{ $producto->variedad ?: 'Variedad no especificada' }}</p>
                                                </div>
                                                <div class="flex flex-wrap gap-2 text-sm font-semibold">
                                                    <span class="rounded-full bg-white px-3 py-1 text-slate-700 ring-1 ring-slate-200">
                                                        {{ $producto->pivot->cantidad }} {{ $producto->pivot->cantidad === 1 ? 'unidad' : 'unidades' }}
                                                    </span>
                                                    <span class="rounded-full bg-white px-3 py-1 text-slate-700 ring-1 ring-slate-200">
                                                        {{ number_format((float) $producto->pivot->precio_unitario, 2, ',', '.') }} € / ud.
                                                    </span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <aside class="rounded-[1.75rem] border border-agro-primary/10 bg-agro-bg/70 p-5">
                                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-agro-brown">Resumen del pedido</p>
                                    <dl class="mt-4 space-y-4">
                                        <div class="flex items-center justify-between gap-4 border-b border-agro-primary/10 pb-4">
                                            <dt class="text-sm text-slate-500">Total del pedido</dt>
                                            <dd class="text-2xl font-black text-agro-primary">{{ number_format((float) $pedido->precio_total, 2, ',', '.') }} €</dd>
                                        </div>
                                        <div class="flex items-center justify-between gap-4">
                                            <dt class="text-sm text-slate-500">Entrega</dt>
                                            <dd class="text-right text-sm font-semibold text-slate-700">
                                                {{ $pedido->tipoEnvio === 'EnvioCasa' ? 'Recíbelo en tu dirección guardada' : 'Coordinación de recogida con el vendedor' }}
                                            </dd>
                                        </div>
                                        <div class="flex items-center justify-between gap-4">
                                            <dt class="text-sm text-slate-500">Líneas</dt>
                                            <dd class="text-sm font-semibold text-slate-700">{{ $pedido->productos->count() }}</dd>
                                        </div>
                                    </dl>
                                </aside>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </section>
    </main>

    <footer class="mt-auto bg-agro-primary text-white">
        <div class="mx-auto grid max-w-7xl gap-8 px-6 py-10 md:grid-cols-3">
            <div class="flex flex-col gap-3">
                <span class="text-2xl font-bold">AgroVentas</span>
                <p class="text-base text-green-200">Pedidos claros, productos frescos y gestión sencilla en cada compra.</p>
            </div>

            <div class="flex flex-col gap-2">
                <span class="text-lg font-semibold text-agro-accent">Accesos</span>
                <a href="{{ route('todos.productos') }}" class="text-green-200 transition-colors hover:text-white">Explorar productos</a>
                <a href="{{ route('carrito.all') }}" class="text-green-200 transition-colors hover:text-white">Ver carrito</a>
                <a href="{{ route('perfil.editar') }}" class="text-green-200 transition-colors hover:text-white">Editar perfil</a>
            </div>

            <div class="flex flex-col gap-2">
                <span class="text-lg font-semibold text-agro-accent">Contacto</span>
                <a href="mailto:contacto@agroventas.es" class="text-green-200 transition-colors hover:text-white">contacto@agroventas.es</a>
                <span class="text-green-200">Seguimiento sencillo para compradores y vendedores.</span>
            </div>
        </div>
    </footer>
</body>
</html>
