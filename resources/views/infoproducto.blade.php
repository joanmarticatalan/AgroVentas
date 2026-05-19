@extends('layouts.estructura-agro')

@section('title', $producto->nombre . ' - AgroVentas')
@section('body_class', 'pagina-infoproducto')

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

        .pagina-infoproducto {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .pagina-infoproducto .miga-navegacion,
        .pagina-infoproducto .miga-navegacion *,
        .pagina-infoproducto main,
        .pagina-infoproducto main * {
            box-sizing: border-box;
        }

        /* Breadcrumb */
        .miga-navegacion {
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

        .miga-navegacion a {
            color: var(--agro-muted);
            text-decoration: none;
            transition: color 0.2s;
        }

        .miga-navegacion a:hover { color: var(--agro-primary); }
        .miga-separador { color: #ccc; }
        .miga-actual { color: var(--agro-primary); font-weight: 600; }

        /* Main */
        .pagina-infoproducto main {
            flex: 1;
            position: relative;
            z-index: 1;
            padding: 2rem 2rem 5rem;
        }

        .producto-interior {
            max-width: 1100px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: start;
        }

        /* Panel imagen */
        .producto-panel-imagen {
            animation: fadeUp 0.6s ease both;
        }

        .producto-marco-imagen {
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

        .producto-marco-imagen img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Placeholder si no hay imagen */
        .imagen-marcador {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #e8e4da 0%, #f0ece4 100%);
        }

        .marcador-icono {
            width: 80px;
            height: 80px;
            opacity: 0.25;
        }

        .marcador-texto {
            font-family: 'Playfair Display', serif;
            font-size: 1rem;
            color: var(--agro-muted);
            font-style: italic;
        }

        /* Etiqueta de categoría sobre la imagen */
        .producto-insignia {
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
        .producto-detalles {
            animation: fadeUp 0.6s 0.12s ease both;
            padding-top: 0.5rem;
        }

        /* Línea decorativa superior tipo etiqueta artesanal */
        .producto-adorno {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            margin-bottom: 1.2rem;
        }

        .adorno-linea {
            flex: 1;
            height: 1px;
            background: var(--agro-brown);
            opacity: 0.3;
        }

        .adorno-punto {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background-color: var(--agro-accent);
        }

        .producto-variedad {
            font-size: 0.85rem;
            font-weight: 700;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--agro-accent);
            margin-bottom: 0.6rem;
        }

        .producto-nombre {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2.2rem, 4vw, 3.2rem);
            font-weight: 900;
            color: var(--agro-primary);
            line-height: 1.05;
            letter-spacing: -0.02em;
            margin-bottom: 1.5rem;
        }

        .producto-precio {
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
        .producto-ficha {
            background: #fff;
            border-radius: 14px;
            padding: 1.5rem;
            border: 1px solid rgba(0,0,0,0.05);
            margin-bottom: 2rem;
            display: flex;
            flex-direction: column;
            gap: 0;
        }

        .ficha-fila {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            padding: 0.85rem 0;
            border-bottom: 1px solid #f0ece4;
            gap: 1rem;
        }

        .ficha-fila:last-child { border-bottom: none; }

        .ficha-etiqueta {
            font-size: 0.85rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--agro-muted);
            flex-shrink: 0;
        }

        .ficha-valor {
            font-size: 1rem;
            font-weight: 600;
            color: var(--agro-text);
            text-align: right;
        }

        .ficha-valor.vendedor {
            color: var(--agro-primary);
            font-family: 'Playfair Display', serif;
            font-size: 1.05rem;
        }

        /* Botón añadir al carrito */
        .boton-carrito {
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

        .boton-carrito:hover {
            background-color: #c06820;
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(217,123,42,0.3);
        }

        .boton-volver {
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

        .boton-volver:hover {
            border-color: var(--agro-primary);
            color: var(--agro-primary);
        }

        /* Sello artesanal decorativo */
        .sello-artesano {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-top: 1.5rem;
            padding: 1rem 1.2rem;
            background: rgba(45,106,45,0.05);
            border-radius: 10px;
            border: 1px solid rgba(45,106,45,0.12);
        }

        .sello-icono {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: var(--agro-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .sello-icono svg { width: 18px; height: 18px; fill: #fff; }

        .sello-texto {
            font-size: 0.88rem;
            color: var(--agro-primary);
            line-height: 1.4;
            font-weight: 600;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 768px) {
            .producto-interior { grid-template-columns: 1fr; gap: 2rem; }
        }
    </style>
@endpush

@section('content')
    <div class="miga-navegacion">
        <a href="{{ route('inicio') }}">Inicio</a>
        <span class="miga-separador">/</span>
        <a href="{{ route('todos.productos') }}">Productos</a>
        <span class="miga-separador">/</span>
        <span class="miga-actual">{{ $producto->nombre }}</span>
    </div>

    <main>
        <div class="producto-interior">

            {{-- PANEL IMAGEN --}}
            <div class="producto-panel-imagen">
                <div class="producto-marco-imagen">
                    @if($producto->imagen)
                        <img src="{{ asset('storage/' . $producto->imagen) }}" alt="{{ $producto->nombre }}">
                    @else
                        <div class="imagen-marcador">
                            <svg class="marcador-icono" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z" fill="#2D6A2D" opacity="0.3"/>
                            </svg>
                            <span class="marcador-texto">Sin imagen disponible</span>
                        </div>
                    @endif
                    <div class="producto-insignia">{{ $producto->variedad }}</div>
                </div>
            </div>

            {{-- PANEL DETALLES --}}
            <div class="producto-detalles">

                <div class="producto-adorno">
                    <div class="adorno-linea"></div>
                    <div class="adorno-punto"></div>
                    <div class="adorno-linea"></div>
                </div>

                <div class="producto-variedad">{{ $producto->variedad }}</div>

                <h1 class="producto-nombre">{{ $producto->nombre }}</h1>

                <div class="producto-precio">
                    <span class="precio-valor">{{ number_format($producto->precio, 2) }}</span>
                    <span class="precio-unidad">€ / kg</span>
                </div>

                <div class="producto-ficha">
                    <div class="ficha-fila">
                        <span class="ficha-etiqueta">Vendedor</span>
                        <span class="ficha-valor vendedor">{{ $user->name }}</span>
                    </div>
                    <div class="ficha-fila">
                        <span class="ficha-etiqueta">Fecha de producción</span>
                        <span class="ficha-valor">{{ \Carbon\Carbon::parse($producto->fechaProduccion)->format('d/m/Y') }}</span>
                    </div>
                    @if($producto->localizacion)
                    <div class="ficha-fila">
                        <span class="ficha-etiqueta">Origen</span>
                        <span class="ficha-valor">{{ $producto->localizacion->provincia }}</span>
                    </div>
                    @endif
                    <div class="ficha-fila">
                        <span class="ficha-etiqueta">Stock disponible</span>
                        <span class="ficha-valor">{{ $producto->stock }} kg</span>
                    </div>
                </div>

                <form action="/carrito/agregar/{{ $producto->id }}" method="POST" style="display:grid; gap:0.9rem;">
                    @csrf
                    <div style="display:grid; gap:0.45rem; max-width: 180px;">
                        <label for="cantidad" style="font-size:0.92rem; font-weight:700; color:#274c2f; letter-spacing:0.04em; text-transform:uppercase;">
                            Cantidad
                        </label>
                        <input
                            id="cantidad"
                            name="cantidad"
                            type="number"
                            min="1"
                            max="{{ $producto->stock }}"
                            value="{{ old('cantidad', 1) }}"
                            style="border:1px solid rgba(39,76,47,0.18); border-radius:14px; padding:0.9rem 1rem; font-size:1rem; color:#17301d; background:#fffdf8;"
                            required
                        >
                        @error('cantidad')
                            <span style="font-size:0.9rem; color:#9f2d2d;">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="boton-carrito">
                        Añadir al carrito
                    </button>
                </form>

                <a href="{{ route('todos.productos') }}" class="boton-volver">
                    Volver al listado
                </a>

                <div class="sello-artesano">
                    <div class="sello-icono">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-2 16l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/>
                        </svg>
                    </div>
                    <span class="sello-texto">Producto de origen local verificado por AgroVentas</span>
                </div>

            </div>

        </div>
    </main>
@endsection
