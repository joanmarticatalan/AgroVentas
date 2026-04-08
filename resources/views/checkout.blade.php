<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar pedido — AgroVentas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,700&family=Source+Sans+3:wght@400;600&display=swap" rel="stylesheet">
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
            border: none;
            cursor: pointer;
            transition: background 0.2s, transform 0.15s;
        }

        .btn-nav:hover { background-color: #c06820; transform: translateY(-1px); }

        .checkout-progress {
            background: #fff;
            border-bottom: 1px solid rgba(0,0,0,0.06);
            position: relative;
            z-index: 1;
        }

        .progress-inner {
            max-width: 1000px;
            margin: 0 auto;
            padding: 1.2rem 2rem;
            display: flex;
            align-items: center;
        }

        .progress-step {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            flex: 1;
        }

        .step-circle {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            font-weight: 700;
            flex-shrink: 0;
        }

        .step-active .step-circle { background-color: var(--agro-primary); color: #fff; }
        .step-done .step-circle { background-color: var(--agro-secondary); color: #fff; }
        .step-pending .step-circle { background-color: #e8e0d4; color: var(--agro-muted); }

        .step-label { font-size: 0.9rem; font-weight: 600; }
        .step-active .step-label { color: var(--agro-primary); }
        .step-done .step-label { color: var(--agro-secondary); }
        .step-pending .step-label { color: var(--agro-muted); }

        .step-divider {
            flex: 1;
            height: 1px;
            background: #e0dbd0;
            margin: 0 0.5rem;
        }

        main {
            flex: 1;
            position: relative;
            z-index: 1;
            padding: 2.5rem 2rem 5rem;
        }

        .checkout-form {
            max-width: 1000px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 2rem;
            align-items: start;
            animation: fadeUp 0.5s ease both;
        }

        .form-sections {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .form-block {
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid rgba(0,0,0,0.05);
        }

        .block-header {
            padding: 1.3rem 1.8rem;
            border-bottom: 1px solid #f0ece4;
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .block-number {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: var(--agro-primary);
            color: #fff;
            font-size: 0.85rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .block-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--agro-primary);
        }

        .block-body { padding: 1.8rem; }

        .envio-options {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .envio-option { position: relative; }

        .envio-option input[type="radio"] {
            position: absolute;
            opacity: 0;
            width: 0;
        }

        .envio-label {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.6rem;
            padding: 1.5rem 1rem;
            border: 2px solid #e0dbd0;
            border-radius: 12px;
            cursor: pointer;
            transition: border-color 0.2s, background 0.2s;
            text-align: center;
            background: var(--agro-bg);
        }

        .envio-label:hover { border-color: var(--agro-secondary); }

        .envio-option input[type="radio"]:checked + .envio-label {
            border-color: var(--agro-primary);
            background: rgba(45,106,45,0.05);
        }

        .envio-name { font-weight: 700; font-size: 1rem; color: var(--agro-text); }
        .envio-desc { font-size: 0.85rem; color: var(--agro-muted); line-height: 1.4; }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .form-group { display: flex; flex-direction: column; gap: 0.4rem; }
        .form-group.span-2 { grid-column: span 2; }
        .form-label { font-weight: 600; font-size: 0.95rem; color: var(--agro-text); }

        .form-input {
            font-family: 'Source Sans 3', sans-serif;
            font-size: 1.05rem;
            padding: 0.8rem 1rem;
            border: 1.5px solid #e0dbd0;
            border-radius: 10px;
            background: var(--agro-bg);
            color: var(--agro-text);
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
            outline: none;
            width: 100%;
        }

        .form-input:focus {
            border-color: var(--agro-primary);
            box-shadow: 0 0 0 3px rgba(45,106,45,0.1);
            background: #fff;
        }

        .pago-info {
            background: rgba(45,106,45,0.05);
            border: 1.5px dashed rgba(45,106,45,0.2);
            border-radius: 12px;
            padding: 1.5rem;
            display: flex;
            align-items: flex-start;
            gap: 1rem;
        }

        .pago-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--agro-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .pago-icon svg { width: 20px; height: 20px; fill: #fff; }

        .pago-text h4 {
            font-family: 'Playfair Display', serif;
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--agro-primary);
            margin-bottom: 0.3rem;
        }

        .pago-text p { color: var(--agro-muted); font-size: 0.95rem; line-height: 1.5; }

        .order-summary {
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid rgba(0,0,0,0.05);
            position: sticky;
            top: 90px;
        }

        .summary-header {
            background-color: var(--agro-primary);
            padding: 1.3rem 1.8rem;
        }

        .summary-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: 1.25rem;
            font-weight: 700;
            color: #fff;
        }

        .summary-body { padding: 1.5rem; }

        .summary-item {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 0.7rem 0;
            border-bottom: 1px solid #f0ece4;
            gap: 0.5rem;
        }

        .summary-item:last-of-type { border-bottom: none; }
        .summary-item-name { font-size: 0.95rem; color: var(--agro-text); font-weight: 600; flex: 1; }
        .summary-item-qty { font-size: 0.85rem; color: var(--agro-muted); }
        .summary-item-price { font-size: 0.95rem; font-weight: 600; color: var(--agro-text); white-space: nowrap; }

        .summary-divider { border: none; border-top: 2px solid #e8e0d4; margin: 1rem 0; }

        .summary-total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .total-label {
            font-family: 'Playfair Display', serif;
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--agro-primary);
        }

        .total-value {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 900;
            color: var(--agro-primary);
            line-height: 1;
        }

        .total-value small { font-size: 1rem; color: var(--agro-accent); font-weight: 600; }

        .btn-confirm {
            width: 100%;
            font-family: 'Source Sans 3', sans-serif;
            font-size: 1.15rem;
            font-weight: 600;
            padding: 1.1rem;
            border-radius: 12px;
            border: none;
            background-color: var(--agro-accent);
            color: #fff;
            cursor: pointer;
            transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
        }

        .btn-confirm:hover {
            background-color: #c06820;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(217,123,42,0.3);
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 0.8rem;
            color: var(--agro-muted);
            font-size: 0.95rem;
            text-decoration: none;
            transition: color 0.2s;
        }

        .back-link:hover { color: var(--agro-primary); }

        .multi-order-notice {
            background: rgba(217,123,42,0.08);
            border: 1px solid rgba(217,123,42,0.25);
            border-radius: 10px;
            padding: 1rem 1.2rem;
            margin-bottom: 1.2rem;
        }

        .notice-text { font-size: 0.92rem; color: var(--agro-brown); line-height: 1.5; }

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
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 768px) {
            .checkout-form { grid-template-columns: 1fr; }
            .order-summary { position: static; }
            .envio-options { grid-template-columns: 1fr; }
            .form-grid { grid-template-columns: 1fr; }
            .form-group.span-2 { grid-column: span 1; }
            .footer-inner { grid-template-columns: 1fr; }
            .step-label { font-size: 0.75rem; }
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
                @endauth
            </div>
        </div>
    </header>

    {{-- BARRA DE PROGRESO --}}
    <div class="checkout-progress">
        <div class="progress-inner">
            <div class="progress-step step-done">
                <div class="step-circle">1</div>
                <span class="step-label">Carrito</span>
            </div>
            <div class="step-divider"></div>
            <div class="progress-step step-active">
                <div class="step-circle">2</div>
                <span class="step-label">Confirmar pedido</span>
            </div>
            <div class="step-divider"></div>
            <div class="progress-step step-pending">
                <div class="step-circle">3</div>
                <span class="step-label">Pedido realizado</span>
            </div>
        </div>
    </div>

    <main>

        <form action="{{ route('checkout.confirm') }}" method="POST" class="checkout-form">
            @csrf

            {{-- COLUMNA IZQUIERDA --}}
            <div class="form-sections">

                {{-- 1. Tipo de envío --}}
                <div class="form-block">
                    <div class="block-header">
                        <div class="block-number">1</div>
                        <div class="block-title">Tipo de entrega</div>
                    </div>
                    <div class="block-body">
                        <div class="envio-options">
                            <div class="envio-option">
                                <input type="radio" id="envio-casa" name="tipoEnvio" value="EnvioCasa" checked>
                                <label for="envio-casa" class="envio-label">
                                    <span class="envio-name">Envío a domicilio</span>
                                    <span class="envio-desc">Recibe tu pedido en la dirección que indiques</span>
                                </label>
                            </div>
                            <div class="envio-option">
                                <input type="radio" id="envio-recoger" name="tipoEnvio" value="A recoger">
                                <label for="envio-recoger" class="envio-label">
                                    <span class="envio-name">Recogida en punto</span>
                                    <span class="envio-desc">Recoge directamente en el punto de venta del vendedor</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 2. Dirección --}}
                <div class="form-block">
                    <div class="block-header">
                        <div class="block-number">2</div>
                        <div class="block-title">Dirección de entrega</div>
                    </div>
                    <div class="block-body">
                        <p style="color:var(--agro-muted); font-size:0.95rem; margin-bottom:1.3rem;">
                            Elige si quieres reutilizar tu dirección guardada o indicar una nueva para este pedido.
                        </p>

                        @php($selectedAddressOption = old('direccion_opcion', $defaultAddressOption))

                        <input type="hidden" name="localizacion_id" value="{{ $localizacion->id ?? '' }}">

                        <div class="envio-options" style="margin-bottom: 1.5rem;">
                            <div class="envio-option">
                                <input
                                    type="radio"
                                    id="direccion-actual"
                                    name="direccion_opcion"
                                    value="actual"
                                    {{ $selectedAddressOption === 'actual' ? 'checked' : '' }}
                                    {{ $localizacion ? '' : 'disabled' }}
                                >
                                <label for="direccion-actual" class="envio-label">
                                    <span class="envio-name">Usar dirección actual</span>
                                    <span class="envio-desc">
                                        {{ $localizacion ? trim(($localizacion->nombreCalle ?? '') . ' ' . ($localizacion->numero ?? '') . ', ' . ($localizacion->provincia ?? ''), ' ,') : 'No tienes una dirección guardada.' }}
                                    </span>
                                </label>
                            </div>
                            <div class="envio-option">
                                <input
                                    type="radio"
                                    id="direccion-nueva"
                                    name="direccion_opcion"
                                    value="nueva"
                                    {{ $selectedAddressOption === 'nueva' ? 'checked' : '' }}
                                >
                                <label for="direccion-nueva" class="envio-label">
                                    <span class="envio-name">Usar una dirección nueva</span>
                                    <span class="envio-desc">Solo se guardará una nueva localización si eliges esta opción.</span>
                                </label>
                            </div>
                        </div>

                        <div class="form-grid">
                            <div class="form-group span-2">
                                <label class="form-label">Calle</label>
                                <input type="text" name="nueva_nombreCalle" class="form-input"
                                       value="{{ old('nueva_nombreCalle', $localizacion->nombreCalle ?? '') }}"
                                       placeholder="Calle Mayor" maxlength="50">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Número</label>
                                <input type="text" name="nueva_numero" class="form-input"
                                       value="{{ old('nueva_numero', $localizacion->numero ?? '') }}"
                                       placeholder="12" maxlength="5">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Puerta <span style="font-weight:400; color:var(--agro-muted);">(opcional)</span></label>
                                <input type="text" name="nueva_puerta" class="form-input"
                                       value="{{ old('nueva_puerta', $localizacion->puerta ?? '') }}"
                                       placeholder="2A" maxlength="10">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Código Postal</label>
                                <input type="text" name="nueva_codigoPostal" class="form-input"
                                       value="{{ old('nueva_codigoPostal', $localizacion->codigoPostal ?? '') }}"
                                       placeholder="46001" maxlength="5">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Provincia</label>
                                <input type="text" name="nueva_provincia" class="form-input"
                                       value="{{ old('nueva_provincia', $localizacion->provincia ?? '') }}"
                                       placeholder="Valencia" maxlength="50">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 3. Pago --}}
                <div class="form-block">
                    <div class="block-header">
                        <div class="block-number">3</div>
                        <div class="block-title">Pago</div>
                    </div>
                    <div class="block-body">
                        <div class="pago-info">
                            <div class="pago-icon">
                                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 4l5 2.18V11c0 3.5-2.33 6.79-5 7.93-2.67-1.14-5-4.43-5-7.93V7.18L12 5z"/>
                                </svg>
                            </div>
                            <div class="pago-text">
                                <h4>Pago contra entrega</h4>
                                <p>El pago se realizará en el momento de recibir tu pedido. No necesitas introducir datos bancarios.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- COLUMNA DERECHA: resumen + botón dentro del form --}}
            <div class="order-summary">
                <div class="summary-header">
                    <h2>Resumen del pedido</h2>
                </div>
                <div class="summary-body">
                    @if($sellerCount > 1)
                        <div class="multi-order-notice">
                            <span class="notice-text">
                                Tu pedido incluye productos de <strong>{{ $sellerCount }} vendedores distintos</strong>. Los tiempos de entrega pueden variar según cada vendedor.
                            </span>
                        </div>
                    @endif

                    @foreach($cart as $line)
                        @php($subtotal = $line['price'] * $line['quantity'])
                        <div class="summary-item">
                            <div>
                                <div class="summary-item-name">{{ $line['name'] }}</div>
                                <div class="summary-item-qty">x {{ $line['quantity'] }} kg</div>
                            </div>
                            <div class="summary-item-price">{{ number_format($subtotal, 2) }} €</div>
                        </div>
                    @endforeach

                    <hr class="summary-divider">

                    <div class="summary-total">
                        <span class="total-label">Total</span>
                        <span class="total-value">{{ number_format($orderTotal, 2) }} <small>€</small></span>
                    </div>

                    <button type="submit" class="btn-confirm">
                        Confirmar y pagar
                    </button>

                    <a href="{{ route('carrito.all') }}" class="back-link">Volver al carrito</a>

                </div>
            </div>

        </form>

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
