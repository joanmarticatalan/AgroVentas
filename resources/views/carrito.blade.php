@extends('layouts.estructura-agro')

@section('title', 'Tu carrito - AgroVentas')
@section('body_class', 'pagina-carrito')

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

        .pagina-carrito {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .pagina-carrito main,
        .pagina-carrito main * {
            box-sizing: border-box;
        }

        .pagina-carrito main {
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

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 768px) {
            .carrito-distribucion { grid-template-columns: 1fr; }
            .carrito-articulo { grid-template-columns: 1fr; gap: 1rem; }
            .carrito-resumen { position: static; }
        }
    </style>
@endpush

@section('content')
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
                    <h2>Tu carrito está vacío</h2>
                    <p>Aún no has añadido ningún producto. ¡Explora nuestra tienda!</p>
                    <a href="{{ route('todos.productos') }}" class="boton-ir-tienda">
                        Ver productos
                    </a>
                </div>

            @endif

        </div>
    </main>
@endsection
