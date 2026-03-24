<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear cuenta — AgroVentas</title>
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

        /* Hero strip */
        .page-hero {
            background-color: var(--agro-primary);
            padding: 3rem 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .page-hero::before {
            content: '';
            position: absolute;
            width: 500px; height: 500px;
            border-radius: 50%;
            border: 1px solid rgba(255,255,255,0.06);
            top: -200px; left: -100px;
        }

        .page-hero::after {
            content: '';
            position: absolute;
            width: 300px; height: 300px;
            border-radius: 50%;
            border: 1px solid rgba(217,123,42,0.15);
            bottom: -150px; right: 5%;
        }

        .page-hero-tag {
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
            margin-bottom: 1rem;
        }

        .page-hero h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2.8rem;
            font-weight: 900;
            color: #fff;
            letter-spacing: -0.02em;
            line-height: 1.1;
        }

        .page-hero h1 span {
            color: var(--agro-accent);
            font-style: italic;
        }

        .page-hero p {
            color: rgba(255,255,255,0.65);
            font-size: 1.1rem;
            margin-top: 0.6rem;
        }

        /* Contenedor del formulario */
        main {
            flex: 1;
            position: relative;
            z-index: 1;
            padding: 3rem 2rem 4rem;
        }

        .form-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 8px 40px rgba(0,0,0,0.08);
            max-width: 760px;
            margin: 0 auto;
            overflow: hidden;
            animation: fadeUp 0.6s ease both;
        }

        /* Secciones del formulario */
        .form-section {
            padding: 2.5rem 3rem;
            border-bottom: 1px solid #f0ece4;
        }

        .form-section:last-child { border-bottom: none; }

        .section-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.8rem;
        }

        .section-number {
            width: 32px; height: 32px;
            border-radius: 50%;
            background-color: var(--agro-primary);
            color: #fff;
            font-size: 0.9rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--agro-primary);
        }

        .section-desc {
            color: var(--agro-muted);
            font-size: 0.95rem;
            margin-top: 0.2rem;
        }

        /* Campos */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.2rem;
        }

        .form-grid.full { grid-template-columns: 1fr; }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.4rem;
        }

        .form-group.span-2 { grid-column: span 2; }

        .form-label {
            font-weight: 600;
            font-size: 1rem;
            color: var(--agro-text);
        }

        .form-label .optional {
            font-weight: 400;
            color: var(--agro-muted);
            font-size: 0.9rem;
        }

        .form-input,
        .form-select {
            font-family: 'Source Sans 3', sans-serif;
            font-size: 1.05rem;
            padding: 0.85rem 1.1rem;
            border: 1.5px solid #e0dbd0;
            border-radius: 10px;
            background: var(--agro-bg);
            color: var(--agro-text);
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
            outline: none;
            width: 100%;
        }

        .form-input:focus,
        .form-select:focus {
            border-color: var(--agro-primary);
            box-shadow: 0 0 0 3px rgba(45,106,45,0.1);
            background: #fff;
        }

        .form-input::placeholder { color: #bbb; }

        .form-error {
            color: #b91c1c;
            font-size: 0.9rem;
            margin-top: 0.2rem;
        }

        /* Sección opcional */
        .optional-section {
            background: var(--agro-bg);
            border-radius: 12px;
            padding: 1.5rem;
            border: 1.5px dashed #d6cfc3;
        }

        .optional-badge {
            display: inline-block;
            background: rgba(217,123,42,0.12);
            color: var(--agro-accent);
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            padding: 0.2rem 0.7rem;
            border-radius: 100px;
            margin-bottom: 0.5rem;
        }

        /* Botón submit */
        .form-submit-area {
            padding: 2rem 3rem 2.5rem;
            background: var(--agro-bg);
            text-align: center;
        }

        .btn-submit {
            font-family: 'Source Sans 3', sans-serif;
            font-size: 1.2rem;
            font-weight: 600;
            padding: 1.1rem 3.5rem;
            border-radius: 12px;
            border: none;
            background-color: var(--agro-primary);
            color: #fff;
            cursor: pointer;
            transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
        }

        .btn-submit:hover {
            background-color: var(--agro-secondary);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(45,106,45,0.25);
        }

        .form-footer-link {
            margin-top: 1rem;
            color: var(--agro-muted);
            font-size: 1rem;
        }

        .form-footer-link a {
            color: var(--agro-primary);
            font-weight: 600;
            text-decoration: none;
        }

        .form-footer-link a:hover { text-decoration: underline; }

        /* Error general */
        .error-box {
            background: #fff0f0;
            border: 1px solid #fca5a5;
            border-radius: 10px;
            padding: 1rem 1.3rem;
            margin: 0 3rem 0;
        }

        .error-box li {
            color: #b91c1c;
            font-size: 0.95rem;
            margin-left: 1rem;
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

        @media (max-width: 640px) {
            .form-section { padding: 1.5rem; }
            .form-grid { grid-template-columns: 1fr; }
            .form-group.span-2 { grid-column: span 1; }
            .form-submit-area { padding: 1.5rem; }
            .error-box { margin: 0 1.5rem; }
            .footer-inner { grid-template-columns: 1fr; }
            .page-hero h1 { font-size: 2rem; }
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

    {{-- HERO STRIP --}}
    <div class="page-hero">
        <div class="page-hero-tag">🌱 Únete a la comunidad</div>
        <h1>Crea tu <span>cuenta</span></h1>
        <p>Empieza a comprar y vender productos del campo en minutos</p>
    </div>

    {{-- FORMULARIO --}}
    <main>

        @if ($errors->any())
            <div class="error-box" style="max-width:760px; margin: 0 auto 1.5rem;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form-card">
            <form action="{{ route('register') }}" method="POST">
                @csrf

                {{-- Sección 1: Datos personales --}}
                <div class="form-section">
                    <div class="section-header">
                        <div class="section-number">1</div>
                        <div>
                            <div class="section-title">Datos personales</div>
                            <div class="section-desc">Tu información básica de contacto</div>
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group span-2">
                            <label for="name" class="form-label">Nombre completo</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}"
                                   class="form-input" placeholder="Joan García" required>
                            @error('name') <span class="form-error">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label">Correo electrónico</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}"
                                   class="form-input" placeholder="ejemplo@correo.com" required>
                            @error('email') <span class="form-error">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="text" id="telefono" name="telefono" value="{{ old('telefono') }}"
                                   class="form-input" placeholder="612 345 678" required>
                            @error('telefono') <span class="form-error">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" id="password" name="password"
                                   class="form-input" placeholder="Mínimo 8 caracteres" required>
                            @error('password') <span class="form-error">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation" class="form-label">Repetir contraseña</label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                   class="form-input" placeholder="Repite tu contraseña" required>
                        </div>
                    </div>
                </div>

                {{-- Sección 2: Tipo de cuenta --}}
                <div class="form-section">
                    <div class="section-header">
                        <div class="section-number">2</div>
                        <div>
                            <div class="section-title">Tipo de cuenta</div>
                            <div class="section-desc">¿Cómo vas a usar AgroVentas?</div>
                        </div>
                    </div>

                    <div class="form-grid full">
                        <div class="form-group">
                            <label for="tipoCliente" class="form-label">Selecciona tu perfil</label>
                            <select id="tipoCliente" name="tipoCliente" class="form-select" required>
                                <option value="">Selecciona una opción</option>
                                <option value="comprador" {{ old('tipoCliente') == 'comprador' ? 'selected' : '' }}>
                                    🛒 Comprador — Quiero comprar productos del campo
                                </option>
                                <option value="vendedor" {{ old('tipoCliente') == 'vendedor' ? 'selected' : '' }}>
                                    📦 Vendedor — Quiero vender mis productos
                                </option>
                                <option value="compraventa" {{ old('tipoCliente') == 'compraventa' ? 'selected' : '' }}>
                                    🔄 Compra-Venta — Quiero comprar y vender
                                </option>
                            </select>
                            @error('tipoCliente') <span class="form-error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                {{-- Sección 3: Localización --}}
                <div class="form-section">
                    <div class="section-header">
                        <div class="section-number">3</div>
                        <div>
                            <div class="section-title">Dirección <span style="font-family:'Source Sans 3',sans-serif; font-size:0.9rem; font-weight:400; color:var(--agro-muted);">(opcional)</span></div>
                            <div class="section-desc">Puedes añadirla ahora o más tarde desde tu perfil</div>
                        </div>
                    </div>

                    {{-- Localización existente --}}
                    <div class="optional-section" style="margin-bottom:1.2rem;">
                        <div class="optional-badge">Usar existente</div>
                        <p style="color:var(--agro-muted); font-size:0.95rem; margin-bottom:0.8rem;">
                            Si ya existe tu dirección en el sistema, selecciónala aquí.
                        </p>
                        <select name="localizacion_id" class="form-select">
                            <option value="">-- Ninguna --</option>
                            @foreach($localizaciones as $loc)
                                <option value="{{ $loc->id }}" {{ old('localizacion_id') == $loc->id ? 'selected' : '' }}>
                                    {{ $loc->nombreCalle }}, {{ $loc->numero }} ({{ $loc->provincia }})
                                </option>
                            @endforeach
                        </select>
                        @error('localizacion_id') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    {{-- Nueva localización --}}
                    <div class="optional-section">
                        <div class="optional-badge">Crear nueva</div>
                        <p style="color:var(--agro-muted); font-size:0.95rem; margin-bottom:1.2rem;">
                            O rellena los campos para crear una nueva dirección.
                        </p>

                        <div class="form-grid" style="gap:1rem;">
                            <div class="form-group">
                                <label class="form-label">Provincia</label>
                                <input type="text" name="nueva_provincia" value="{{ old('nueva_provincia') }}"
                                       maxlength="50" class="form-input" placeholder="Valencia">
                                @error('nueva_provincia') <span class="form-error">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label">Código Postal</label>
                                <input type="text" name="nueva_codigoPostal" value="{{ old('nueva_codigoPostal') }}"
                                       maxlength="5" class="form-input" placeholder="46410">
                                @error('nueva_codigoPostal') <span class="form-error">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group span-2">
                                <label class="form-label">Calle</label>
                                <input type="text" name="nueva_nombreCalle" value="{{ old('nueva_nombreCalle') }}"
                                       maxlength="50" class="form-input" placeholder="Calle Mayor">
                                @error('nueva_nombreCalle') <span class="form-error">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label">Número</label>
                                <input type="text" name="nueva_numero" value="{{ old('nueva_numero') }}"
                                       maxlength="5" class="form-input" placeholder="12">
                                @error('nueva_numero') <span class="form-error">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label">Puerta <span class="optional">(opcional)</span></label>
                                <input type="text" name="nueva_puerta" value="{{ old('nueva_puerta') }}"
                                       maxlength="10" class="form-input" placeholder="2ºA">
                                @error('nueva_puerta') <span class="form-error">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Botón --}}
                <div class="form-submit-area">
                    <button type="submit" class="btn-submit">Crear mi cuenta</button>
                    <p class="form-footer-link">
                        ¿Ya tienes cuenta? <a href="/login">Inicia sesión</a>
                    </p>
                </div>

            </form>
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