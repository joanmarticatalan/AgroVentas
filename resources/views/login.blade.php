<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión — AgroVentas</title>
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
            transition: background 0.2s, transform 0.15s;
        }

        .btn-nav:hover {
            background-color: #c06820;
            transform: translateY(-1px);
        }

        /* Layout principal */
        main {
            flex: 1;
            display: grid;
            grid-template-columns: 1fr 1fr;
            position: relative;
            z-index: 1;
        }

        /* Panel izquierdo decorativo */
        .login-deco {
            background-color: var(--agro-primary);
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: center;
            padding: 4rem 3.5rem;
            position: relative;
            overflow: hidden;
        }

        .login-deco::before {
            content: '';
            position: absolute;
            width: 400px; height: 400px;
            border-radius: 50%;
            border: 1px solid rgba(255,255,255,0.08);
            bottom: -100px; right: -100px;
        }

        .login-deco::after {
            content: '';
            position: absolute;
            width: 250px; height: 250px;
            border-radius: 50%;
            border: 1px solid rgba(217,123,42,0.2);
            bottom: -30px; right: -30px;
        }

        .deco-tag {
            display: inline-block;
            background: rgba(255,255,255,0.1);
            color: rgba(255,255,255,0.8);
            font-size: 0.8rem;
            font-weight: 600;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            padding: 0.35rem 1rem;
            border-radius: 100px;
            border: 1px solid rgba(255,255,255,0.15);
            margin-bottom: 1.5rem;
        }

        .deco-title {
            font-family: 'Playfair Display', serif;
            font-size: 3rem;
            font-weight: 900;
            color: #fff;
            line-height: 1.1;
            letter-spacing: -0.02em;
            margin-bottom: 1rem;
        }

        .deco-title span {
            color: var(--agro-accent);
            font-style: italic;
        }

        .deco-text {
            color: rgba(255,255,255,0.65);
            font-size: 1.1rem;
            line-height: 1.65;
            max-width: 340px;
            margin-bottom: 2.5rem;
        }

        .deco-features {
            display: flex;
            flex-direction: column;
            gap: 0.85rem;
        }

        .deco-feature {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: rgba(255,255,255,0.8);
            font-size: 1rem;
        }

        .deco-feature-dot {
            width: 8px; height: 8px;
            border-radius: 50%;
            background-color: var(--agro-accent);
            flex-shrink: 0;
        }

        /* Panel derecho: formulario */
        .login-form-panel {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 4rem 3rem;
            background-color: var(--agro-bg);
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            animation: fadeUp 0.6s ease both;
        }

        .login-card h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--agro-primary);
            margin-bottom: 0.4rem;
        }

        .login-card .subtitle {
            color: var(--agro-muted);
            font-size: 1.05rem;
            margin-bottom: 2.2rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.4rem;
            margin-bottom: 1.2rem;
        }

        .form-label {
            font-weight: 600;
            font-size: 1rem;
            color: var(--agro-text);
        }

        .form-input {
            font-family: 'Source Sans 3', sans-serif;
            font-size: 1.05rem;
            padding: 0.85rem 1.1rem;
            border: 1.5px solid #ddd;
            border-radius: 10px;
            background: #fff;
            color: var(--agro-text);
            transition: border-color 0.2s, box-shadow 0.2s;
            outline: none;
        }

        .form-input:focus {
            border-color: var(--agro-primary);
            box-shadow: 0 0 0 3px rgba(45,106,45,0.1);
        }

        .form-input::placeholder { color: #aaa; }

        .error-box {
            background: #fff0f0;
            border: 1px solid #fca5a5;
            border-radius: 10px;
            padding: 0.9rem 1.1rem;
            margin-bottom: 1.5rem;
        }

        .error-box li {
            color: #b91c1c;
            font-size: 0.95rem;
            margin-left: 1rem;
        }

        .btn-submit {
            width: 100%;
            font-family: 'Source Sans 3', sans-serif;
            font-size: 1.15rem;
            font-weight: 600;
            padding: 1rem;
            border-radius: 10px;
            border: none;
            background-color: var(--agro-primary);
            color: #fff;
            cursor: pointer;
            transition: background 0.2s, transform 0.15s;
            margin-top: 0.5rem;
        }

        .btn-submit:hover {
            background-color: var(--agro-secondary);
            transform: translateY(-2px);
        }

        .form-footer {
            text-align: center;
            margin-top: 1.3rem;
            color: var(--agro-muted);
            font-size: 1rem;
        }

        .form-footer a {
            color: var(--agro-primary);
            font-weight: 600;
            text-decoration: none;
        }

        .form-footer a:hover { text-decoration: underline; }

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

        .footer-brand {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.4rem;
        }

        .footer-brand span { color: var(--agro-accent); }

        .footer-col-title {
            font-weight: 600;
            color: var(--agro-accent);
            margin-bottom: 0.6rem;
            display: block;
        }

        .footer-link {
            display: block;
            color: rgba(255,255,255,0.65);
            text-decoration: none;
            font-size: 0.95rem;
            margin-bottom: 0.4rem;
            transition: color 0.2s;
        }

        .footer-link:hover { color: #fff; }

        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.1);
            text-align: center;
            padding: 1.1rem;
            color: rgba(255,255,255,0.4);
            font-size: 0.85rem;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 768px) {
            main { grid-template-columns: 1fr; }
            .login-deco { display: none; }
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
                <a href="/products" class="nav-link">Productos</a>
            </nav>
            <div style="display:flex; align-items:center; gap:1rem;">
                <a href="/carro" class="nav-link">🛒 Carrito</a>
                <a href="/login" class="nav-link">Iniciar sesión</a>
                <a href="/register" class="btn-nav">Registrarse</a>
            </div>
        </div>
    </header>

    {{-- MAIN: dos columnas --}}
    <main>

        {{-- Panel izquierdo decorativo --}}
        <div class="login-deco">
            <div class="deco-tag">🌿 Bienvenido de nuevo</div>
            <h2 class="deco-title">Tu campo,<br>tu <span>mercado</span></h2>
            <p class="deco-text">
                Accede a tu cuenta y gestiona tus compras y ventas de productos agrícolas directamente desde el campo.
            </p>
            <div class="deco-features">
                <div class="deco-feature">
                    <div class="deco-feature-dot"></div>
                    Productos frescos de origen local
                </div>
                <div class="deco-feature">
                    <div class="deco-feature-dot"></div>
                    Trato directo con el agricultor
                </div>
                <div class="deco-feature">
                    <div class="deco-feature-dot"></div>
                    Gestión sencilla de pedidos
                </div>
            </div>
        </div>

        {{-- Panel derecho: formulario --}}
        <div class="login-form-panel">
            <div class="login-card">

                <h1>Iniciar sesión</h1>
                <p class="subtitle">Introduce tus datos para acceder</p>

                @if ($errors->any())
                    <div class="error-box">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="email" class="form-label">Correo electrónico</label>
                        <input type="email" id="email" name="email" class="form-input"
                               placeholder="ejemplo@correo.com" value="{{ old('email') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" id="password" name="password" class="form-input"
                               placeholder="Tu contraseña" required>
                    </div>

                    <button type="submit" class="btn-submit">Entrar</button>

                    <p class="form-footer">
                        ¿No tienes cuenta? <a href="/register">Créala aquí</a>
                    </p>
                </form>

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