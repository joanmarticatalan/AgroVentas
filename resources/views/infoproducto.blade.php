<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $producto->nombre }} — AgroVentas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400;1,700&family=Source+Sans+3:wght@400;600&display=swap" rel="stylesheet">
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
        .navbar {
            background-color: var(--agro-primary);
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 20px rgba(0,0,0,0.15);
        }

        .nav-inner {
            max-width: 1280px;
            margin: 0 auto;
            padding: 1rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .nav-brand {
            font-family: 'Playfair Display', serif;
            font-size: 1.6rem;
            font-weight: 700;
            color: #fff;
            text-decoration: none;
        }

        .nav-brand span { color: var(--agro-accent); }

        .nav-link {
            color: rgba(255,255,255,0.85);
            font-size: 1.05rem;
            font-weight: 600;
            text-decoration: none;
            position: relative;
            transition: color 0.2s;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -3px; left: 0;
            width: 0; height: 2px;
            background: var(--agro-accent);
            transition: width 0.25s;
        }

        .nav-link:hover { color: #fff; }
        .nav-link:hover::after { width: 100%; }

        .btn-nav {
            background-color: var(--agro-accent);
            color: #fff;
            font-family: 'Source Sans 3', sans-serif;
            font-weight: 600;
            font-size: 1rem;
            padding: 0.55rem 1.3rem;
            border-radius: 8px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: background 0.2s, transform 0.15s;
        }

        .btn-nav:hover { background-color: #c06820; transform: translateY(-1px); }

        /* Breadcrumb */
        .breadcrumb {
            position: relative;
            z-index: 1;
            max-width: 1100px;
            margin: 0 auto;
            padding: 1.2rem 2rem 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            color: var(--agro-muted);
        }

        .breadcrumb a {
            color: var(--agro-muted);
            text-decoration: none;
            transition: color 0.2s;
        }

        .breadcrumb a:hover { color: var(--agro-primary); }
        .breadcrumb-sep { color: #ccc; }
        .breadcrumb-current { color: var(--agro-primary); font-weight: 600; }

        /* Main */
        main {
            flex: 1;
            position: relative;
            z-index: 1;
            padding: 2rem 2rem 5rem;
        }

        .product-inner {
            max-width: 1100px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: start;
        }

        /* Panel imagen */
        .product-image-panel {
            animation: fadeUp 0.6s ease both;
        }

        .product-image-wrap {
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            aspect-ratio: 1 / 1;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(0,0,0,0.05);
            position: relative;
        }

        .product-image-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Placeholder si no hay imagen */
        .image-placeholder {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #e8e4da 0%, #f0ece4 100%);
        }

        .placeholder-icon {
            width: 80px;
            height: 80px;
            opacity: 0.25;
        }

        .placeholder-text {
            font-family: 'Playfair Display', serif;
            font-size: 1rem;
            color: var(--agro-muted);
            font-style: italic;
        }

        /* Etiqueta de categoría sobre la imagen */
        .product-badge {
            position: absolute;
            top: 1.2rem;
            left: 1.2rem;
            background-color: var(--agro-primary);
            color: #fff;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            padding: 0.3rem 0.9rem;
            border-radius: 100px;
        }

        /* Panel detalles */
        .product-details {
            animation: fadeUp 0.6s 0.12s ease both;
            padding-top: 0.5rem;
        }

        /* Línea decorativa superior tipo etiqueta artesanal */
        .product-ornament {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            margin-bottom: 1.2rem;
        }

        .ornament-line {
            flex: 1;
            height: 1px;
            background: var(--agro-brown);
            opacity: 0.3;
        }

        .ornament-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background-color: var(--agro-accent);
        }

        .product-variedad {
            font-size: 0.85rem;
            font-weight: 700;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--agro-accent);
            margin-bottom: 0.6rem;
        }

        .product-nombre {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2.2rem, 4vw, 3.2rem);
            font-weight: 900;
            color: var(--agro-primary);
            line-height: 1.05;
            letter-spacing: -0.02em;
            margin-bottom: 1.5rem;
        }

        .product-precio {
            display: flex;
            align-items: baseline;
            gap: 0.4rem;
            margin-bottom: 2rem;
        }

        .precio-valor {
            font-family: 'Playfair Display', serif;
            font-size: 2.8rem;
            font-weight: 900;
            color: var(--agro-text);
            line-height: 1;
        }

        .precio-unidad {
            font-size: 1.1rem;
            color: var(--agro-muted);
            font-weight: 600;
        }

        /* Ficha de datos */
        .product-ficha {
            background: #fff;
            border-radius: 14px;
            padding: 1.5rem;
            border: 1px solid rgba(0,0,0,0.05);
            margin-bottom: 2rem;
            display: flex;
            flex-direction: column;
            gap: 0;
        }

        .ficha-row {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            padding: 0.85rem 0;
            border-bottom: 1px solid #f0ece4;
            gap: 1rem;
        }

        .ficha-row:last-child { border-bottom: none; }

        .ficha-label {
            font-size: 0.85rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--agro-muted);
            flex-shrink: 0;
        }

        .ficha-value {
            font-size: 1rem;
            font-weight: 600;
            color: var(--agro-text);
            text-align: right;
        }

        .ficha-value.vendedor {
            color: var(--agro-primary);
            font-family: 'Playfair Display', serif;
            font-size: 1.05rem;
        }

        /* Botón añadir al carrito */
        .btn-carrito {
            width: 100%;
            font-family: 'Source Sans 3', sans-serif;
            font-size: 1.2rem;
            font-weight: 700;
            padding: 1.2rem;
            border-radius: 14px;
            border: none;
            background-color: var(--agro-accent);
            color: #fff;
            cursor: pointer;
            transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
            letter-spacing: 0.02em;
            margin-bottom: 1rem;
        }

        .btn-carrito:hover {
            background-color: #c06820;
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(217,123,42,0.3);
        }

        .btn-volver {
            display: block;
            width: 100%;
            text-align: center;
            font-family: 'Source Sans 3', sans-serif;
            font-size: 1rem;
            font-weight: 600;
            padding: 0.9rem;
            border-radius: 12px;
            border: 1.5px solid #d6cfc3;
            background: transparent;
            color: var(--agro-muted);
            text-decoration: none;
            transition: border-color 0.2s, color 0.2s;
        }

        .btn-volver:hover {
            border-color: var(--agro-primary);
            color: var(--agro-primary);
        }

        /* Sello artesanal decorativo */
        .artisan-seal {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-top: 1.5rem;
            padding: 1rem 1.2rem;
            background: rgba(45,106,45,0.05);
            border-radius: 10px;
            border: 1px solid rgba(45,106,45,0.12);
        }

        .seal-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: var(--agro-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .seal-icon svg { width: 18px; height: 18px; fill: #fff; }

        .seal-text {
            font-size: 0.88rem;
            color: var(--agro-primary);
            line-height: 1.4;
            font-weight: 600;
        }

        /* Footer */
        footer {
            background-color: var(--agro-primary);
            color: #fff;
            position: relative;
            z-index: 1;
        }

        .footer-inner {
            max-width: 1280px;
            margin: 0 auto;
            padding: 3rem 2rem;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
        }

        .footer-brand { font-family: 'Playfair Display', serif; font-size: 1.5rem; font-weight: 700; margin-bottom: 0.4rem; }
        .footer-brand span { color: var(--agro-accent); }
        .footer-col-title { font-weight: 600; color: var(--agro-accent); margin-bottom: 0.6rem; display: block; }
        .footer-link { display: block; color: rgba(255,255,255,0.65); text-decoration: none; font-size: 0.95rem; margin-bottom: 0.4rem; transition: color 0.2s; }
        .footer-link:hover { color: #fff; }
        .footer-bottom { border-top: 1px solid rgba(255,255,255,0.1); text-align: center; padding: 1.1rem; color: rgba(255,255,255,0.4); font-size: 0.85rem; }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 768px) {
            .product-inner { grid-template-columns: 1fr; gap: 2rem; }
            .footer-inner { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    {{-- NAVBAR --}}
    <header class="navbar">
        <div class="nav-inner">
            <a href="/" class="nav-brand">Agro<span>Ventas</span></a>

            <nav style="display:flex; align-items:center; gap:2rem;">
                <a href="/" class="nav-link">Inicio</a>
                <a href="{{ route('todos.productos') }}" class="nav-link">Productos</a>
                @auth
                    <a href="{{ route('pedidos.usuario') }}" class="nav-link">Mis pedidos</a>
                    @if(auth()->user()->tipoCliente === 'vendedor' || auth()->user()->tipoCliente === 'compraventa')
                        <a href="{{ route('mis.productos') }}" class="nav-link">Mis productos</a>
                        <a href="{{ route('pg.anadir.producto') }}" class="nav-link">Vender</a>
                    @endif
                    @if(auth()->user()->tipoCliente === 'admin')
                        <a href="{{ route('users.index') }}" class="nav-link">Usuarios</a>
                    @endif
                @endauth
            </nav>

            <div style="display:flex; align-items:center; gap:1rem;">
                <a href="{{ route('carrito.all') }}" class="nav-link">Carrito</a>
                @auth
                    <a href="{{ route('perfil.editar') }}" class="nav-link">Mi perfil</a>
                    <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                        @csrf
                        <button type="submit" class="btn-nav">Salir</button>
                    </form>
                @else
                    <a href="/login" class="nav-link">Iniciar sesión</a>
                    <a href="/register" class="btn-nav">Registrarse</a>
                @endauth
            </div>
        </div>
    </header>

    {{-- BREADCRUMB --}}
    <div class="breadcrumb">
        <a href="/">Inicio</a>
        <span class="breadcrumb-sep">/</span>
        <a href="{{ route('todos.productos') }}">Productos</a>
        <span class="breadcrumb-sep">/</span>
        <span class="breadcrumb-current">{{ $producto->nombre }}</span>
    </div>

    <main>
        <div class="product-inner">

            {{-- PANEL IMAGEN --}}
            <div class="product-image-panel">
                <div class="product-image-wrap">
                    @if($producto->imagen)
                        <img src="{{ asset('storage/' . $producto->imagen) }}" alt="{{ $producto->nombre }}">
                    @else
                        <div class="image-placeholder">
                            <svg class="placeholder-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z" fill="#2D6A2D" opacity="0.3"/>
                            </svg>
                            <span class="placeholder-text">Sin imagen disponible</span>
                        </div>
                    @endif
                    <div class="product-badge">{{ $producto->variedad }}</div>
                </div>
            </div>

            {{-- PANEL DETALLES --}}
            <div class="product-details">

                <div class="product-ornament">
                    <div class="ornament-line"></div>
                    <div class="ornament-dot"></div>
                    <div class="ornament-line"></div>
                </div>

                <div class="product-variedad">{{ $producto->variedad }}</div>

                <h1 class="product-nombre">{{ $producto->nombre }}</h1>

                <div class="product-precio">
                    <span class="precio-valor">{{ number_format($producto->precio, 2) }}</span>
                    <span class="precio-unidad">€ / kg</span>
                </div>

                <div class="product-ficha">
                    <div class="ficha-row">
                        <span class="ficha-label">Vendedor</span>
                        <span class="ficha-value vendedor">{{ $user->name }}</span>
                    </div>
                    <div class="ficha-row">
                        <span class="ficha-label">Fecha de producción</span>
                        <span class="ficha-value">{{ \Carbon\Carbon::parse($producto->fechaProduccion)->format('d/m/Y') }}</span>
                    </div>
                    @if($producto->localizacion)
                    <div class="ficha-row">
                        <span class="ficha-label">Origen</span>
                        <span class="ficha-value">{{ $producto->localizacion->provincia }}</span>
                    </div>
                    @endif
                    <div class="ficha-row">
                        <span class="ficha-label">Stock disponible</span>
                        <span class="ficha-value">{{ $producto->stock }} kg</span>
                    </div>
                </div>

                <form action="/carrito/agregar/{{ $producto->id }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-carrito">
                        Añadir al carrito
                    </button>
                </form>

                <a href="{{ route('todos.productos') }}" class="btn-volver">
                    Volver al listado
                </a>

                <div class="artisan-seal">
                    <div class="seal-icon">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-2 16l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/>
                        </svg>
                    </div>
                    <span class="seal-text">Producto de origen local verificado por AgroVentas</span>
                </div>

            </div>

        </div>
    </main>

    {{-- FOOTER --}}
    <footer>
        <div class="footer-inner">
            <div>
                <div class="footer-brand">Agro<span>Ventas</span></div>
                <p style="color:rgba(255,255,255,0.55); font-size:0.95rem;">Del huerto a casa.</p>
            </div>
            <div>
                <span class="footer-col-title">Información</span>
                <a href="mailto:contacto@agroventas.es" class="footer-link">contacto@agroventas.es</a>
                <a href="/aviso-legal" class="footer-link">Aviso legal</a>
                <a href="/privacidad" class="footer-link">Política de privacidad</a>
            </div>
            <div>
                <span class="footer-col-title">Síguenos</span>
                <a href="https://linkedin.com" target="_blank" class="footer-link">LinkedIn</a>
                <a href="https://github.com" target="_blank" class="footer-link">GitHub</a>
            </div>
        </div>
        <div class="footer-bottom">
            © {{ date('Y') }} AgroVentas. Todos los derechos reservados.
        </div>
    </footer>

</body>
</html>