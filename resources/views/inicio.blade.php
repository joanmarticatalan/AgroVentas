<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AgroVentas — Del huerto a casa</title>
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

        body {
            font-family: 'Source Sans 3', sans-serif;
            background-color: var(--agro-bg);
        }

        .font-display {
            font-family: 'Playfair Display', serif;
        }

        /* Grain texture overlay */
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

        .nav-link {
            color: rgba(255,255,255,0.85);
            font-size: 1.05rem;
            font-weight: 600;
            letter-spacing: 0.03em;
            text-decoration: none;
            transition: color 0.2s;
            position: relative;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -3px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--agro-accent);
            transition: width 0.25s;
        }

        .nav-link:hover { color: #fff; }
        .nav-link:hover::after { width: 100%; }

        .btn-primary {
            background-color: var(--agro-accent);
            color: #fff;
            font-family: 'Source Sans 3', sans-serif;
            font-weight: 600;
            font-size: 1.1rem;
            padding: 0.6rem 1.4rem;
            border-radius: 8px;
            text-decoration: none;
            transition: background 0.2s, transform 0.15s;
            display: inline-block;
        }

        .btn-primary:hover {
            background-color: #c06820;
            transform: translateY(-1px);
        }

        /* Hero */
        .hero {
            min-height: 88vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        /* Decorative circle */
        .hero-circle {
            position: absolute;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(45,106,45,0.08) 0%, transparent 70%);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            pointer-events: none;
        }

        .hero-decoration {
            position: absolute;
            right: 8%;
            top: 50%;
            transform: translateY(-50%);
            width: 320px;
            height: 320px;
            border: 2px solid rgba(45,106,45,0.15);
            border-radius: 50%;
            pointer-events: none;
        }

        .hero-decoration::before {
            content: '';
            position: absolute;
            inset: 20px;
            border: 1px solid rgba(217,123,42,0.2);
            border-radius: 50%;
        }

        .hero-tag {
            display: inline-block;
            background: rgba(45,106,45,0.1);
            color: var(--agro-primary);
            font-size: 0.85rem;
            font-weight: 600;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            padding: 0.35rem 1rem;
            border-radius: 100px;
            border: 1px solid rgba(45,106,45,0.2);
            margin-bottom: 1.5rem;
        }

        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(3.5rem, 8vw, 7rem);
            font-weight: 900;
            line-height: 1;
            color: var(--agro-primary);
            letter-spacing: -0.02em;
        }

        .hero-title span {
            color: var(--agro-accent);
            font-style: italic;
        }

        .hero-subtitle {
            font-size: 1.35rem;
            color: var(--agro-muted);
            max-width: 480px;
            line-height: 1.6;
            margin: 1.5rem 0 2.5rem;
        }

        /* CTA buttons */
        .cta-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            font-family: 'Source Sans 3', sans-serif;
            font-size: 1.25rem;
            font-weight: 600;
            padding: 1.1rem 2.5rem;
            border-radius: 12px;
            text-decoration: none;
            transition: transform 0.2s, box-shadow 0.2s;
            cursor: pointer;
        }

        .cta-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.15);
        }

        .cta-comprar {
            background-color: var(--agro-primary);
            color: #fff;
        }

        .cta-vender {
            background-color: transparent;
            color: var(--agro-primary);
            border: 2px solid var(--agro-primary);
        }

        .cta-vender:hover {
            background-color: var(--agro-primary);
            color: #fff;
        }

        /* Stats strip */
        .stats-strip {
            background-color: var(--agro-primary);
            color: #fff;
        }

        .stat-number {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--agro-accent);
            line-height: 1;
        }

        .stat-label {
            font-size: 0.95rem;
            color: rgba(255,255,255,0.75);
            margin-top: 0.3rem;
        }

        /* Features */
        .feature-card {
            background: #fff;
            border-radius: 16px;
            padding: 2rem;
            border: 1px solid rgba(0,0,0,0.06);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .feature-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 32px rgba(0,0,0,0.08);
        }

        .feature-icon {
            width: 52px;
            height: 52px;
            background: rgba(45,106,45,0.1);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .feature-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.35rem;
            font-weight: 700;
            color: var(--agro-primary);
            margin-bottom: 0.5rem;
        }

        .feature-text {
            color: var(--agro-muted);
            font-size: 1.05rem;
            line-height: 1.6;
        }

        /* Footer */
        .footer {
            background-color: var(--agro-primary);
            color: #fff;
        }

        /* Entrance animations */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .animate-1 { animation: fadeUp 0.7s ease both; }
        .animate-2 { animation: fadeUp 0.7s 0.15s ease both; }
        .animate-3 { animation: fadeUp 0.7s 0.3s ease both; }
        .animate-4 { animation: fadeUp 0.7s 0.45s ease both; }
        .animate-5 { animation: fadeUp 0.7s 0.6s ease both; }
    </style>
</head>
<body style="background-color: var(--agro-bg); color: var(--agro-text);">

    {{-- NAVBAR --}}
    <header class="navbar">
        <div style="max-width: 1280px; margin: 0 auto; padding: 1rem 2rem; display: flex; align-items: center; justify-content: space-between;">

            <a href="/" style="font-family: 'Playfair Display', serif; font-size: 1.6rem; font-weight: 700; color: #fff; text-decoration: none; letter-spacing: -0.01em;">
                Agro<span style="color: var(--agro-accent);">Ventas</span>
            </a>

            <nav style="display: flex; align-items: center; gap: 2.5rem;">
                <a href="/" class="nav-link">Inicio</a>
                <a href="/products" class="nav-link">Productos</a>
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

            <div style="display: flex; align-items: center; gap: 1rem;">
                <a href="/carro" class="nav-link">🛒 Carrito</a>
                @auth
                    <a href="{{ route('perfil.editar') }}" class="nav-link">Mi perfil</a>
                    <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                        @csrf
                        <button type="submit" class="btn-primary">Salir</button>
                    </form>
                @else
                    <a href="/login" class="nav-link">Iniciar sesión</a>
                    <a href="/register" class="btn-primary">Registrarse</a>
                @endauth
            </div>

        </div>
    </header>

    {{-- HERO --}}
    <main>
        <section class="hero">
            <div class="hero-circle"></div>
            <div class="hero-decoration"></div>

            <div style="max-width: 1280px; margin: 0 auto; padding: 4rem 2rem; position: relative; z-index: 1;">
                <div style="max-width: 640px;">

                    <div class="hero-tag animate-1">🌿 Plataforma agrícola valenciana</div>

                    <h1 class="hero-title animate-2">
                        Del huerto<br>a <span>tu mesa</span>
                    </h1>

                    <p class="hero-subtitle animate-3">
                        Compra y vende productos del campo directamente entre agricultores y consumidores. Sin intermediarios, con total confianza.
                    </p>

                    <div class="animate-4" style="display: flex; gap: 1rem; flex-wrap: wrap;">
                        <a href="/products" class="cta-btn cta-comprar">
                            🛒 Quiero comprar
                        </a>
                        <a href="/products" class="cta-btn cta-vender">
                            📦 Quiero vender
                        </a>
                    </div>

                </div>
            </div>
        </section>

        {{-- STATS STRIP --}}
        <section class="stats-strip">
            <div style="max-width: 1280px; margin: 0 auto; padding: 2.5rem 2rem; display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem; text-align: center;">
                <div>
                    <div class="stat-number">100%</div>
                    <div class="stat-label">Productos de origen local</div>
                </div>
                <div style="border-left: 1px solid rgba(255,255,255,0.15); border-right: 1px solid rgba(255,255,255,0.15);">
                    <div class="stat-number">0</div>
                    <div class="stat-label">Intermediarios</div>
                </div>
                <div>
                    <div class="stat-number">24h</div>
                    <div class="stat-label">Gestión de pedidos</div>
                </div>
            </div>
        </section>

        {{-- FEATURES --}}
        <section style="padding: 6rem 2rem;">
            <div style="max-width: 1280px; margin: 0 auto;">

                <div style="text-align: center; margin-bottom: 3.5rem;">
                    <h2 class="font-display" style="font-size: 2.8rem; font-weight: 700; color: var(--agro-primary); letter-spacing: -0.02em;">
                        ¿Por qué AgroVentas?
                    </h2>
                    <p style="color: var(--agro-muted); font-size: 1.15rem; margin-top: 0.75rem;">Simple, directo y pensado para el campo.</p>
                </div>

                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem;">

                    <div class="feature-card">
                        <div class="feature-icon">🌱</div>
                        <div class="feature-title">Producto fresco</div>
                        <p class="feature-text">Conectamos directamente al agricultor con el comprador. El producto llega en su mejor momento.</p>
                    </div>

                    <div class="feature-card">
                        <div class="feature-icon">🤝</div>
                        <div class="feature-title">Trato directo</div>
                        <p class="feature-text">Sin complicaciones. Habla directamente con quien cultiva y elige lo que necesitas.</p>
                    </div>

                    <div class="feature-card">
                        <div class="feature-icon">📍</div>
                        <div class="feature-title">De tu zona</div>
                        <p class="feature-text">Apoya a los agricultores de tu comarca. Consume local y contribuye a la economía de tu región.</p>
                    </div>

                </div>
            </div>
        </section>

        {{-- CTA FINAL --}}
        <section style="background: #fff; padding: 5rem 2rem; text-align: center; border-top: 1px solid rgba(0,0,0,0.06);">
            <div style="max-width: 600px; margin: 0 auto;">
                <h2 class="font-display" style="font-size: 2.5rem; font-weight: 700; color: var(--agro-primary); margin-bottom: 1rem;">
                    Empieza hoy mismo
                </h2>
                <p style="color: var(--agro-muted); font-size: 1.15rem; margin-bottom: 2rem;">
                    Registrarte es gratis y solo lleva un momento.
                </p>
                <a href="/register" class="cta-btn cta-comprar" style="font-size: 1.3rem; padding: 1.2rem 3rem;">
                    Crear cuenta gratis
                </a>
            </div>
        </section>
    </main>

    {{-- FOOTER --}}
    <footer class="footer">
        <div style="max-width: 1280px; margin: 0 auto; padding: 3.5rem 2rem; display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem;">

            <div>
                <div style="font-family: 'Playfair Display', serif; font-size: 1.6rem; font-weight: 700; margin-bottom: 0.5rem;">
                    Agro<span style="color: var(--agro-accent);">Ventas</span>
                </div>
                <p style="color: rgba(255,255,255,0.65); font-size: 1rem;">Del huerto a casa.</p>
            </div>

            <div style="display: flex; flex-direction: column; gap: 0.6rem;">
                <span style="font-weight: 600; color: var(--agro-accent); margin-bottom: 0.3rem;">Información</span>
                <a href="mailto:contacto@agroventas.es" style="color: rgba(255,255,255,0.7); text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='rgba(255,255,255,0.7)'">contacto@agroventas.es</a>
                <a href="/aviso-legal" style="color: rgba(255,255,255,0.7); text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='rgba(255,255,255,0.7)'">Aviso legal</a>
                <a href="/privacidad" style="color: rgba(255,255,255,0.7); text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='rgba(255,255,255,0.7)'">Política de privacidad</a>
            </div>

            <div style="display: flex; flex-direction: column; gap: 0.6rem;">
                <span style="font-weight: 600; color: var(--agro-accent); margin-bottom: 0.3rem;">Síguenos</span>
                <a href="https://linkedin.com" target="_blank" style="color: rgba(255,255,255,0.7); text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='rgba(255,255,255,0.7)'">LinkedIn</a>
                <a href="https://github.com" target="_blank" style="color: rgba(255,255,255,0.7); text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='rgba(255,255,255,0.7)'">GitHub</a>
            </div>

        </div>
        <div style="border-top: 1px solid rgba(255,255,255,0.1); text-align: center; padding: 1.25rem; color: rgba(255,255,255,0.45); font-size: 0.9rem;">
            © {{ date('Y') }} AgroVentas. Todos los derechos reservados.
        </div>
    </footer>

</body>
</html>