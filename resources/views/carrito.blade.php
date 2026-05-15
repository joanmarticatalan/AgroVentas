<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tu carrito — AgroVentas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=Source+Sans+3:wght@400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --agro-primary: #2D6A2D;
            --agro-secondary: #5A9E3A;
            --agro-accent: #D97B2A;
            --agro-brown: #7B5733;
            --agro-bg: #F5F0E8;
            --agro-text: #1A1A1A;
            --agro-muted: #555555;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Source Sans 3', sans-serif;
            background-color: var(--agro-bg);
            color: var(--agro-text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.04'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 0;
            opacity: 0.5;
        }

        /* Navbar */
        .barra-navegacion {
            background-color: var(--agro-primary);
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 20px rgba(0,0,0,0.15);
        }

        .navegacion-interior {
            max-width: 1280px;
            margin: 0 auto;
            padding: 1rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .navegacion-marca {
            font-family: 'Playfair Display', serif;
            font-size: 1.6rem;
            font-weight: 700;
            color: #fff;
            text-decoration: none;
        }

        .navegacion-marca span { color: var(--agro-accent); }

        .navegacion-enlace {
            color: rgba(255,255,255,0.85);
            font-size: 1.05rem;
            font-weight: 600;
            text-decoration: none;
            position: relative;
            transition: color 0.2s;
        }

        .navegacion-enlace::after {
            content: '';
            position: absolute;
            bottom: -3px; left: 0;
            width: 0; height: 2px;
            background: var(--agro-accent);
            transition: width 0.25s;
        }

        .navegacion-enlace:hover { color: #fff; }
        .navegacion-enlace:hover::after { width: 100%; }

        .boton-navegacion {
            background-color: var(--agro-accent);
            color: #fff;
            font-family: 'Source Sans 3', sans-serif;
            font-weight: 600;
            font-size: 1rem;
            padding: 0.55rem 1.3rem;
            border-radius: 8px;
            text-decoration: none;
            transition: background 0.2s, transform 0.15s;
            border: none;
            cursor: pointer;
        }

        .boton-navegacion:hover {
            background-color: #c06820;
            transform: translateY(-1px);
        }

        /* Main layout */
        main {
            flex: 1;
            position: relative;
            z-index: 1;
            padding: 3rem 2rem 5rem;
        }

        .pagina-interior {
            max-width: 1000px;
            margin: 0 auto;
        }

        /* Page header */
        .pagina-encabezado {
            margin-bottom: 2.5rem;
            animation: fadeUp 0.5s ease both;
        }

        .pagina-encabezado h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2.8rem;
            font-weight: 900;
            color: var(--agro-primary);
            letter-spacing: -0.02em;
            line-height: 1;
        }

        .pagina-encabezado h1 span {
            color: var(--agro-accent);
            font-style: italic;
        }

        .enlace-volver {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            color: var(--agro-muted);
            font-size: 0.95rem;
            text-decoration: none;
            margin-bottom: 1rem;
            transition: color 0.2s;
        }

        .enlace-volver:hover { color: var(--agro-primary); }

        /* Layout dos columnas */
        .carrito-distribucion {
            display: grid;
            grid-template-columns: 1fr 320px;
            gap: 2rem;
            align-items: start;
        }

        /* Lista de productos */
        .carrito-articulos {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            animation: fadeUp 0.5s 0.1s ease both;
        }

        .carrito-articulo {
            background: #fff;
            border-radius: 14px;
            padding: 1.5rem;
            display: grid;
            grid-template-columns: 1fr auto auto;
            align-items: center;
            gap: 1.5rem;
            border: 1px solid rgba(0,0,0,0.05);
            transition: box-shadow 0.2s;
        }

        .carrito-articulo:hover {
            box-shadow: 0 4px 20px rgba(0,0,0,0.07);
        }

        .articulo-nombre {
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--agro-primary);
            margin-bottom: 0.25rem;
        }

        .articulo-precio {
            color: var(--agro-muted);
            font-size: 1rem;
        }

        .articulo-precio strong {
            color: var(--agro-accent);
            font-size: 1.1rem;
        }

        /* Cantidad con botones */
        .control-cantidad {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--agro-bg);
            border-radius: 10px;
            padding: 0.4rem 0.6rem;
        }

        .boton-cantidad {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            border: none;
            font-size: 1.2rem;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.15s, transform 0.1s;
            line-height: 1;
        }

        .boton-cantidad:hover { transform: scale(1.1); }

        .boton-cantidad-mas {
            background-color: var(--agro-primary);
            color: #fff;
        }

        .boton-cantidad-mas:hover { background-color: var(--agro-secondary); }

        .boton-cantidad-menos {
            background-color: #e8e0d4;
            color: var(--agro-text);
        }

        .boton-cantidad-menos:hover { background-color: #d6cfc3; }

        .cantidad-numero {
            font-size: 1.15rem;
            font-weight: 700;
            min-width: 28px;
            text-align: center;
            color: var(--agro-text);
        }

        /* Subtotal por línea */
        .articulo-subtotal {
            text-align: right;
            min-width: 90px;
        }

        .subtotal-etiqueta {
            font-size: 0.8rem;
            color: var(--agro-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .subtotal-valor {
            font-family: 'Playfair Display', serif;
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--agro-text);
        }

        /* Panel resumen */
        .carrito-resumen {
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid rgba(0,0,0,0.05);
            position: sticky;
            top: 90px;
            animation: fadeUp 0.5s 0.2s ease both;
        }

        .resumen-encabezado {
            background-color: var(--agro-primary);
            padding: 1.3rem 1.8rem;
        }

        .resumen-encabezado h2 {
            font-family: 'Playfair Display', serif;
            font-size: 1.3rem;
            font-weight: 700;
            color: #fff;
        }

        .resumen-cuerpo {
            padding: 1.8rem;
        }

        .resumen-fila {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.6rem 0;
            font-size: 1rem;
            color: var(--agro-muted);
            border-bottom: 1px solid #f0ece4;
        }

        .resumen-fila:last-of-type { border-bottom: none; }

        .resumen-total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.2rem 0 0.5rem;
            margin-top: 0.5rem;
            border-top: 2px solid #e8e0d4;
        }

        .total-etiqueta {
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--agro-primary);
        }

        .total-valor {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 900;
            color: var(--agro-primary);
        }

        .total-valor span {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--agro-accent);
        }

        .boton-confirmar-compra {
            display: block;
            width: 100%;
            font-family: 'Source Sans 3', sans-serif;
            font-size: 1.15rem;
            font-weight: 600;
            padding: 1rem;
            border-radius: 10px;
            border: none;
            background-color: var(--agro-accent);
            color: #fff;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
            margin-top: 1.2rem;
        }

        .boton-confirmar-compra:hover {
            background-color: #c06820;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(217,123,42,0.3);
        }

        .boton-vaciar {
            display: block;
            width: 100%;
            font-family: 'Source Sans 3', sans-serif;
            font-size: 0.95rem;
            font-weight: 600;
            padding: 0.75rem;
            border-radius: 10px;
            border: 1.5px solid #e0dbd0;
            background: transparent;
            color: var(--agro-muted);
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            transition: border-color 0.2s, color 0.2s;
            margin-top: 0.75rem;
        }

        .boton-vaciar:hover {
            border-color: #b91c1c;
            color: #b91c1c;
        }

        /* Carrito vacío */
        .carrito-vacio {
            text-align: center;
            padding: 5rem 2rem;
            animation: fadeUp 0.5s ease both;
        }

        .vacio-icono {
            font-size: 5rem;
            margin-bottom: 1.5rem;
            opacity: 0.4;
        }

        .carrito-vacio h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 700;
            color: var(--agro-primary);
            margin-bottom: 0.75rem;
        }

        .carrito-vacio p {
            color: var(--agro-muted);
            font-size: 1.1rem;
            margin-bottom: 2rem;
        }

        .boton-ir-tienda {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-family: 'Source Sans 3', sans-serif;
            font-size: 1.1rem;
            font-weight: 600;
            padding: 0.9rem 2.2rem;
            border-radius: 10px;
            background-color: var(--agro-primary);
            color: #fff;
            text-decoration: none;
            transition: background 0.2s, transform 0.15s;
        }

        .boton-ir-tienda:hover {
            background-color: var(--agro-secondary);
            transform: translateY(-2px);
        }

        /* Footer */
        footer {
            background-color: var(--agro-primary);
            color: #fff;
            position: relative;
            z-index: 1;
        }

        .pie-interior {
            max-width: 1280px;
            margin: 0 auto;
            padding: 3rem 2rem;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
        }

        .pie-marca {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.4rem;
        }

        .pie-marca span { color: var(--agro-accent); }

        .pie-columna-titulo {
            font-weight: 600;
            color: var(--agro-accent);
            margin-bottom: 0.6rem;
            display: block;
        }

        .pie-enlace {
            display: block;
            color: rgba(255,255,255,0.65);
            text-decoration: none;
            font-size: 0.95rem;
            margin-bottom: 0.4rem;
            transition: color 0.2s;
        }

        .pie-enlace:hover { color: #fff; }

        .pie-inferior {
            border-top: 1px solid rgba(255,255,255,0.1);
            text-align: center;
            padding: 1.1rem;
            color: rgba(255,255,255,0.4);
            font-size: 0.85rem;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 768px) {
            .carrito-distribucion { grid-template-columns: 1fr; }
            .carrito-articulo { grid-template-columns: 1fr; gap: 1rem; }
            .pie-interior { grid-template-columns: 1fr; }
            .carrito-resumen { position: static; }
        }
    </style>
</head>
<body class="sitio-contenedor">

    {{-- NAVBAR --}}
    @include('partials.cabecera-sitio')

    <main>
        <div class="pagina-interior">

            <div class="pagina-encabezado">
                <a href="{{ route('todos.productos') }}" class="enlace-volver">← Seguir comprando</a>
                <h1>Tu <span>carrito</span></h1>
            </div>

            @if($carro)
                @php $total = 0; @endphp

                <div class="carrito-distribucion">

                    {{-- Lista de productos --}}
                    <div class="carrito-articulos">
                        @foreach($carro as $obj)
                            @php $subtotal = $obj['precio'] * $obj['cantidad']; $total += $subtotal; @endphp

                            <div class="carrito-articulo">
                                <div>
                                    <div class="articulo-nombre">{{ $obj['nombre'] }}</div>
                                    <div class="articulo-precio"><strong>{{ $obj['precio'] }} €</strong> / kg</div>
                                </div>

                                <div class="control-cantidad">
                                    <form action="/carrito/borrar/{{ $obj['id'] }}" method="POST" style="margin:0;">
                                        @csrf
                                        <button type="submit" class="boton-cantidad boton-cantidad-menos">−</button>
                                    </form>
                                    <span class="cantidad-numero">{{ $obj['cantidad'] }}</span>
                                    <form action="/carrito/agregar/{{ $obj['id'] }}" method="POST" style="margin:0;">
                                        @csrf
                                        <input type="hidden" name="cantidad" value="1">
                                        <button type="submit" class="boton-cantidad boton-cantidad-mas">+</button>
                                    </form>
                                </div>

                                <div class="articulo-subtotal">
                                    <div class="subtotal-etiqueta">Subtotal</div>
                                    <div class="subtotal-valor">{{ number_format($subtotal, 2) }} €</div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Panel resumen --}}
                    <div class="carrito-resumen">
                        <div class="resumen-encabezado">
                            <h2>Resumen del pedido</h2>
                        </div>
                        <div class="resumen-cuerpo">

                            @foreach($carro as $obj)
                                <div class="resumen-fila">
                                    <span>{{ $obj['nombre'] }} × {{ $obj['cantidad'] }}</span>
                                    <span>{{ number_format($obj['precio'] * $obj['cantidad'], 2) }} €</span>
                                </div>
                            @endforeach

                            <div class="resumen-total">
                                <span class="total-etiqueta">Total</span>
                                <span class="total-valor">{{ number_format($total, 2) }} <span>€</span></span>
                            </div>

                            <form action="{{ route('checkout') }}" method="GET" style="margin:0;">
                                <button type="submit" class="boton-confirmar-compra">
                                    Confirmar y pagar
                                </button>
                            </form>

                            <a href="{{ route('carrito.all') }}?vaciar=1" class="boton-vaciar"
                               onclick="return confirm('¿Vaciar todo el carrito?')">
                                Vaciar carrito
                            </a>

                        </div>
                    </div>

                </div>

            @else

                {{-- Carrito vacío --}}
                <div class="carrito-vacio">
                    <div class="vacio-icono">AV</div>
                    <h2>Tu carrito está vacío</h2>
                    <p>Aún no has añadido ningún producto. ¡Explora nuestra tienda!</p>
                    <a href="{{ route('todos.productos') }}" class="boton-ir-tienda">
                        Ver productos
                    </a>
                </div>

            @endif

        </div>
    </main>

    {{-- FOOTER --}}
    <footer class="sitio-pie">
        <div class="pie-interior">
            <div>
                <div class="pie-marca">Agro<span>Ventas</span></div>
                <p style="color:rgba(255,255,255,0.55); font-size:0.95rem;">Del huerto a casa.</p>
            </div>
            <div>
                <span class="pie-columna-titulo">Información</span>
                <a href="mailto:contacto@agroventas.es" class="pie-enlace">contacto@agroventas.es</a>
                <a href="/aviso-legal" class="pie-enlace">Aviso legal</a>
                <a href="/privacidad" class="pie-enlace">Política de privacidad</a>
            </div>
            <div>
                <span class="pie-columna-titulo">Síguenos</span>
                <a href="https://linkedin.com" target="_blank" class="pie-enlace">LinkedIn</a>
                <a href="https://github.com" target="_blank" class="pie-enlace">GitHub</a>
            </div>
        </div>
        <div class="pie-inferior">
            © {{ date('Y') }} AgroVentas. Todos los derechos reservados.
        </div>
    </footer>

</body>
</html>
