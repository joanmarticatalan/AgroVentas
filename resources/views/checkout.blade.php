@extends('layouts.estructura-agro')

@section('title', 'Confirmar pedido - AgroVentas')
@section('body_class', 'pagina-checkout')

@push('styles')
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

        .pagina-checkout {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .pagina-checkout .compra-progreso,
        .pagina-checkout .compra-progreso *,
        .pagina-checkout main,
        .pagina-checkout main * {
            box-sizing: border-box;
        }

        .compra-progreso {
            background: #fff;
            border-bottom: 1px solid rgba(0,0,0,0.06);
            position: relative;
            z-index: 1;
        }

        .progreso-interior {
            max-width: 1000px;
            margin: 0 auto;
            padding: 1.2rem 2rem;
            display: flex;
            align-items: center;
        }

        .progreso-paso {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            flex: 1;
        }

        .paso-circulo {
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

        .paso-activo .paso-circulo { background-color: var(--agro-primary); color: #fff; }
        .paso-hecho .paso-circulo { background-color: var(--agro-secondary); color: #fff; }
        .paso-pendiente .paso-circulo { background-color: #e8e0d4; color: var(--agro-muted); }

        .paso-etiqueta { font-size: 0.9rem; font-weight: 600; }
        .paso-activo .paso-etiqueta { color: var(--agro-primary); }
        .paso-hecho .paso-etiqueta { color: var(--agro-secondary); }
        .paso-pendiente .paso-etiqueta { color: var(--agro-muted); }

        .paso-divisor {
            flex: 1;
            height: 1px;
            background: #e0dbd0;
            margin: 0 0.5rem;
        }

        .pagina-checkout main {
            flex: 1;
            position: relative;
            z-index: 1;
            padding: 2.5rem 2rem 5rem;
        }

        .formulario-compra {
            max-width: 1000px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 2rem;
            align-items: start;
            animation: fadeUp 0.5s ease both;
        }

        .secciones-formulario {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .bloque-formulario {
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid rgba(0,0,0,0.05);
        }

        .bloque-encabezado {
            padding: 1.3rem 1.8rem;
            border-bottom: 1px solid #f0ece4;
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .bloque-numero {
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

        .bloque-titulo {
            font-family: 'Playfair Display', serif;
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--agro-primary);
        }

        .bloque-cuerpo { padding: 1.8rem; }

        .opciones-envio {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .opcion-envio { position: relative; }

        .opcion-envio input[type="radio"] {
            position: absolute;
            opacity: 0;
            width: 0;
        }

        .etiqueta-envio {
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

        .etiqueta-envio:hover { border-color: var(--agro-secondary); }

        .opcion-envio input[type="radio"]:checked + .etiqueta-envio {
            border-color: var(--agro-primary);
            background: rgba(45,106,45,0.05);
        }

        .nombre-envio { font-weight: 700; font-size: 1rem; color: var(--agro-text); }
        .descripcion-envio { font-size: 0.85rem; color: var(--agro-muted); line-height: 1.4; }

        .rejilla-formulario {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .grupo-formulario { display: flex; flex-direction: column; gap: 0.4rem; }
        .grupo-formulario.ocupa-dos { grid-column: span 2; }
        .etiqueta-formulario { font-weight: 600; font-size: 0.95rem; color: var(--agro-text); }

        .campo-formulario {
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

        .campo-formulario:focus {
            border-color: var(--agro-primary);
            box-shadow: 0 0 0 3px rgba(45,106,45,0.1);
            background: #fff;
        }

        .pago-informacion {
            background: rgba(45,106,45,0.05);
            border: 1.5px dashed rgba(45,106,45,0.2);
            border-radius: 12px;
            padding: 1.5rem;
            display: flex;
            align-items: flex-start;
            gap: 1rem;
        }

        .pago-icono {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--agro-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .pago-icono svg { width: 20px; height: 20px; fill: #fff; }

        .pago-texto h4 {
            font-family: 'Playfair Display', serif;
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--agro-primary);
            margin-bottom: 0.3rem;
        }

        .pago-texto p { color: var(--agro-muted); font-size: 0.95rem; line-height: 1.5; }

        .resumen-pedido {
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid rgba(0,0,0,0.05);
            position: sticky;
            top: 90px;
        }

        .resumen-encabezado {
            background-color: var(--agro-primary);
            padding: 1.3rem 1.8rem;
        }

        .resumen-encabezado h2 {
            font-family: 'Playfair Display', serif;
            font-size: 1.25rem;
            font-weight: 700;
            color: #fff;
        }

        .resumen-cuerpo { padding: 1.5rem; }

        .resumen-item {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 0.7rem 0;
            border-bottom: 1px solid #f0ece4;
            gap: 0.5rem;
        }

        .resumen-item:last-of-type { border-bottom: none; }
        .resumen-item-nombre { font-size: 0.95rem; color: var(--agro-text); font-weight: 600; flex: 1; }
        .resumen-item-cantidad { font-size: 0.85rem; color: var(--agro-muted); }
        .resumen-item-precio { font-size: 0.95rem; font-weight: 600; color: var(--agro-text); white-space: nowrap; }

        .resumen-divisor { border: none; border-top: 2px solid #e8e0d4; margin: 1rem 0; }

        .resumen-total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .total-etiqueta {
            font-family: 'Playfair Display', serif;
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--agro-primary);
        }

        .total-valor {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 900;
            color: var(--agro-primary);
            line-height: 1;
        }

        .total-valor small { font-size: 1rem; color: var(--agro-accent); font-weight: 600; }

        .boton-confirmar {
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

        .boton-confirmar:hover {
            background-color: #c06820;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(217,123,42,0.3);
        }

        .enlace-volver {
            display: block;
            text-align: center;
            margin-top: 0.8rem;
            color: var(--agro-muted);
            font-size: 0.95rem;
            text-decoration: none;
            transition: color 0.2s;
        }

        .enlace-volver:hover { color: var(--agro-primary); }

        .aviso-multipedido {
            background: rgba(217,123,42,0.08);
            border: 1px solid rgba(217,123,42,0.25);
            border-radius: 10px;
            padding: 1rem 1.2rem;
            margin-bottom: 1.2rem;
        }

        .aviso-texto { font-size: 0.92rem; color: var(--agro-brown); line-height: 1.5; }

        .pila-mensajes {
            max-width: 1000px;
            margin: 0 auto 1.5rem;
            display: grid;
            gap: 1rem;
            animation: fadeUp 0.5s ease both;
        }

        .caja-mensaje {
            border-radius: 14px;
            padding: 1rem 1.2rem;
            border: 1px solid transparent;
        }

        .caja-mensaje p,
        .caja-mensaje li {
            line-height: 1.5;
        }

        .caja-mensaje ul {
            margin: 0.6rem 0 0;
            padding-left: 1.2rem;
        }

        .mensaje-error {
            background: #fff1f2;
            border-color: #fecdd3;
            color: #9f1239;
        }

        .mensaje-exito {
            background: #ecfdf3;
            border-color: #a7f3d0;
            color: #166534;
        }

        .error-campo {
            color: #b91c1c;
            font-size: 0.88rem;
            font-weight: 600;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 768px) {
            .formulario-compra { grid-template-columns: 1fr; }
            .resumen-pedido { position: static; }
            .opciones-envio { grid-template-columns: 1fr; }
            .rejilla-formulario { grid-template-columns: 1fr; }
            .grupo-formulario.ocupa-dos { grid-column: span 1; }
            .paso-etiqueta { font-size: 0.75rem; }
        }
    </style>
@endpush

@section('content')
    <div class="compra-progreso">
        <div class="progreso-interior">
            <div class="progreso-paso paso-hecho">
                <div class="paso-circulo">1</div>
                <span class="paso-etiqueta">Carrito</span>
            </div>
            <div class="paso-divisor"></div>
            <div class="progreso-paso paso-activo">
                <div class="paso-circulo">2</div>
                <span class="paso-etiqueta">Confirmar pedido</span>
            </div>
            <div class="paso-divisor"></div>
            <div class="progreso-paso paso-pendiente">
                <div class="paso-circulo">3</div>
                <span class="paso-etiqueta">Pedido realizado</span>
            </div>
        </div>
    </div>

    <main>
        @php($selectedShippingOption = old('tipoEnvio', 'EnvioCasa'))

        @if(session('error') || session('success') || $errors->any())
            <div class="pila-mensajes">
                @if(session('error'))
                    <div class="caja-mensaje mensaje-error">
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                @if(session('success'))
                    <div class="caja-mensaje mensaje-exito">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                @if($errors->any())
                    <div class="caja-mensaje mensaje-error">
                        <p>Revisa los campos marcados para completar el pedido.</p>
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        @endif

        <form action="{{ route('checkout.confirm') }}" method="POST" class="formulario-compra">
            @csrf

            {{-- COLUMNA IZQUIERDA --}}
            <div class="secciones-formulario">

                {{-- 1. Tipo de envío --}}
                <div class="bloque-formulario">
                    <div class="bloque-encabezado">
                        <div class="bloque-numero">1</div>
                        <div class="bloque-titulo">Tipo de entrega</div>
                    </div>
                    <div class="bloque-cuerpo">
                        <div class="opciones-envio">
                            <div class="opcion-envio">
                                <input type="radio" id="envio-casa" name="tipoEnvio" value="EnvioCasa" {{ $selectedShippingOption === 'EnvioCasa' ? 'checked' : '' }}>
                                <label for="envio-casa" class="etiqueta-envio">
                                    <span class="nombre-envio">Envío a domicilio</span>
                                    <span class="descripcion-envio">Recibe tu pedido en la dirección que indiques</span>
                                </label>
                            </div>
                            <div class="opcion-envio">
                                <input type="radio" id="envio-recoger" name="tipoEnvio" value="A recoger" {{ $selectedShippingOption === 'A recoger' ? 'checked' : '' }}>
                                <label for="envio-recoger" class="etiqueta-envio">
                                    <span class="nombre-envio">Recogida en punto</span>
                                    <span class="descripcion-envio">Recoge directamente en el punto de venta del vendedor</span>
                                </label>
                            </div>
                        </div>
                        @error('tipoEnvio')
                            <p class="error-campo">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- 2. Dirección --}}
                <div class="bloque-formulario">
                    <div class="bloque-encabezado">
                        <div class="bloque-numero">2</div>
                        <div class="bloque-titulo">Dirección de entrega</div>
                    </div>
                    <div class="bloque-cuerpo">
                        <p style="color:var(--agro-muted); font-size:0.95rem; margin-bottom:1.3rem;">
                            Elige si quieres reutilizar tu dirección guardada o indicar una nueva para este pedido.
                        </p>

                        @php($selectedAddressOption = old('direccion_opcion', $defaultAddressOption))

                        <input type="hidden" name="localizacion_id" value="{{ $localizacion->id ?? '' }}">
                        @error('direccion_opcion')
                            <p class="error-campo" style="margin-bottom: 1rem;">{{ $message }}</p>
                        @enderror
                        @error('localizacion_id')
                            <p class="error-campo" style="margin-bottom: 1rem;">{{ $message }}</p>
                        @enderror

                        <div class="opciones-envio" style="margin-bottom: 1.5rem;">
                            <div class="opcion-envio">
                                <input
                                    type="radio"
                                    id="direccion-actual"
                                    name="direccion_opcion"
                                    value="actual"
                                    {{ $selectedAddressOption === 'actual' ? 'checked' : '' }}
                                    {{ $localizacion ? '' : 'disabled' }}
                                >
                                <label for="direccion-actual" class="etiqueta-envio">
                                    <span class="nombre-envio">Usar dirección actual</span>
                                    <span class="descripcion-envio">
                                        {{ $localizacion ? trim(($localizacion->nombreCalle ?? '') . ' ' . ($localizacion->numero ?? '') . ', ' . ($localizacion->provincia ?? ''), ' ,') : 'No tienes una dirección guardada.' }}
                                    </span>
                                </label>
                            </div>
                            <div class="opcion-envio">
                                <input
                                    type="radio"
                                    id="direccion-nueva"
                                    name="direccion_opcion"
                                    value="nueva"
                                    {{ $selectedAddressOption === 'nueva' ? 'checked' : '' }}
                                >
                                <label for="direccion-nueva" class="etiqueta-envio">
                                    <span class="nombre-envio">Usar una dirección nueva</span>
                                    <span class="descripcion-envio">Solo se guardará una nueva localización si eliges esta opción.</span>
                                </label>
                            </div>
                        </div>

                        <div class="rejilla-formulario">
                            <div class="grupo-formulario ocupa-dos">
                                <label class="etiqueta-formulario">Calle</label>
                                <input type="text" name="nueva_nombreCalle" class="campo-formulario"
                                       value="{{ old('nueva_nombreCalle', $localizacion->nombreCalle ?? '') }}"
                                       placeholder="Calle Mayor" maxlength="50">
                                @error('nueva_nombreCalle') <span class="error-campo">{{ $message }}</span> @enderror
                            </div>
                            <div class="grupo-formulario">
                                <label class="etiqueta-formulario">Número</label>
                                <input type="text" name="nueva_numero" class="campo-formulario"
                                       value="{{ old('nueva_numero', $localizacion->numero ?? '') }}"
                                       placeholder="12" maxlength="5">
                                @error('nueva_numero') <span class="error-campo">{{ $message }}</span> @enderror
                            </div>
                            <div class="grupo-formulario">
                                <label class="etiqueta-formulario">Puerta <span style="font-weight:400; color:var(--agro-muted);">(opcional)</span></label>
                                <input type="text" name="nueva_puerta" class="campo-formulario"
                                       value="{{ old('nueva_puerta', $localizacion->puerta ?? '') }}"
                                       placeholder="2A" maxlength="10">
                                @error('nueva_puerta') <span class="error-campo">{{ $message }}</span> @enderror
                            </div>
                            <div class="grupo-formulario">
                                <label class="etiqueta-formulario">Código Postal</label>
                                <input type="text" name="nueva_codigoPostal" class="campo-formulario"
                                       value="{{ old('nueva_codigoPostal', $localizacion->codigoPostal ?? '') }}"
                                       placeholder="46001" maxlength="5">
                                @error('nueva_codigoPostal') <span class="error-campo">{{ $message }}</span> @enderror
                            </div>
                            <div class="grupo-formulario">
                                <label class="etiqueta-formulario">Provincia</label>
                                <input type="text" name="nueva_provincia" class="campo-formulario"
                                       value="{{ old('nueva_provincia', $localizacion->provincia ?? '') }}"
                                       placeholder="Valencia" maxlength="50">
                                @error('nueva_provincia') <span class="error-campo">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 3. Pago --}}
                <div class="bloque-formulario">
                    <div class="bloque-encabezado">
                        <div class="bloque-numero">3</div>
                        <div class="bloque-titulo">Pago</div>
                    </div>
                    <div class="bloque-cuerpo">
                        <div class="pago-informacion">
                            <div class="pago-icono">
                                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 4l5 2.18V11c0 3.5-2.33 6.79-5 7.93-2.67-1.14-5-4.43-5-7.93V7.18L12 5z"/>
                                </svg>
                            </div>
                            <div class="pago-texto">
                                <h4>Pago contra entrega</h4>
                                <p>El pago se realizará en el momento de recibir tu pedido. No necesitas introducir datos bancarios.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- COLUMNA DERECHA: resumen + botón dentro del form --}}
            <div class="resumen-pedido">
                <div class="resumen-encabezado">
                    <h2>Resumen del pedido</h2>
                </div>
                <div class="resumen-cuerpo">
                    @if($sellerCount > 1)
                        <div class="aviso-multipedido">
                            <span class="aviso-texto">
                                Tu pedido incluye productos de <strong>{{ $sellerCount }} vendedores distintos</strong>. Los tiempos de entrega pueden variar según cada vendedor.
                            </span>
                        </div>
                    @endif

                    @foreach($cart as $line)
                        @php($subtotal = ($line['precio'] ?? $line['price']) * ($line['cantidad'] ?? $line['quantity']))
                        <div class="resumen-item">
                            <div>
                                <div class="resumen-item-nombre">{{ $line['nombre'] ?? $line['name'] }}</div>
                                <div class="resumen-item-cantidad">x {{ $line['cantidad'] ?? $line['quantity'] }} kg</div>
                            </div>
                            <div class="resumen-item-precio">{{ number_format($subtotal, 2) }} €</div>
                        </div>
                    @endforeach

                    <hr class="resumen-divisor">

                    <div class="resumen-total">
                        <span class="total-etiqueta">Total</span>
                        <span class="total-valor">{{ number_format($orderTotal, 2) }} <small>€</small></span>
                    </div>

                    <button type="submit" class="boton-confirmar">
                        Confirmar y pagar
                    </button>

                    <a href="{{ route('carrito.all') }}" class="enlace-volver">Volver al carrito</a>

                </div>
            </div>

        </form>

    </main>
@endsection
