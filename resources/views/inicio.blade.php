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

        .fuente-destacada {
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
        .barra-navegacion {
            background-color: var(--agro-primary);
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 20px rgba(0,0,0,0.15);
        }

        .navegacion-enlace {
            color: rgba(255,255,255,0.85);
            font-size: 1.05rem;
            font-weight: 600;
            letter-spacing: 0.03em;
            text-decoration: none;
            transition: color 0.2s;
            position: relative;
        }

        .navegacion-enlace::after {
            content: '';
            position: absolute;
            bottom: -3px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--agro-accent);
            transition: width 0.25s;
        }

        .navegacion-enlace:hover { color: #fff; }
        .navegacion-enlace:hover::after { width: 100%; }

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
        .portada {
            min-height: 88vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        /* Decorative circle */
        .portada-circulo {
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

        .portada-decoracion {
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

        .portada-decoracion::before {
            content: '';
            position: absolute;
            inset: 20px;
            border: 1px solid rgba(217,123,42,0.2);
            border-radius: 50%;
        }

        .portada-etiqueta {
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

        .portada-titulo {
            font-family: 'Playfair Display', serif;
            font-size: clamp(3.5rem, 8vw, 7rem);
            font-weight: 900;
            line-height: 1;
            color: var(--agro-primary);
            letter-spacing: -0.02em;
        }

        .portada-titulo span {
            color: var(--agro-accent);
            font-style: italic;
        }

        .portada-subtitulo {
            font-size: 1.35rem;
            color: var(--agro-muted);
            max-width: 480px;
            line-height: 1.6;
            margin: 1.5rem 0 2.5rem;
        }

        /* CTA buttons */
        .boton-cta {
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

        .boton-cta:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.15);
        }

        .boton-comprar {
            background-color: var(--agro-primary);
            color: #fff;
        }

        .boton-vender {
            background-color: transparent;
            color: var(--agro-primary);
            border: 2px solid var(--agro-primary);
        }

        .boton-vender:hover {
            background-color: var(--agro-primary);
            color: #fff;
        }

        /* Stats strip */
        .franja-estadisticas {
            background-color: var(--agro-primary);
            color: #fff;
        }

        .estadistica-numero {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--agro-accent);
            line-height: 1;
        }

        .estadistica-etiqueta {
            font-size: 0.95rem;
            color: rgba(255,255,255,0.75);
            margin-top: 0.3rem;
        }

        /* Features */
        .caracteristica-tarjeta {
            background: #fff;
            border-radius: 16px;
            padding: 2rem;
            border: 1px solid rgba(0,0,0,0.06);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .caracteristica-tarjeta:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 32px rgba(0,0,0,0.08);
        }

        .caracteristica-icono {
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

        .caracteristica-titulo {
            font-family: 'Playfair Display', serif;
            font-size: 1.35rem;
            font-weight: 700;
            color: var(--agro-primary);
            margin-bottom: 0.5rem;
        }

        .caracteristica-texto {
            color: var(--agro-muted);
            font-size: 1.05rem;
            line-height: 1.6;
        }

        /* Footer */
        .pie-pagina {
            background-color: var(--agro-primary);
            color: #fff;
        }

        /* Entrance animations */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .animacion-1 { animation: fadeUp 0.7s ease both; }
        .animacion-2 { animation: fadeUp 0.7s 0.15s ease both; }
        .animacion-3 { animation: fadeUp 0.7s 0.3s ease both; }
        .animacion-4 { animation: fadeUp 0.7s 0.45s ease both; }
        .animacion-5 { animation: fadeUp 0.7s 0.6s ease both; }
    </style>
</head>
<body class="sitio-contenedor" style="background-color: var(--agro-bg); color: var(--agro-text);">

    {{-- NAVBAR --}}
    @include('partials.cabecera-sitio')

    {{-- HERO --}}
    <main>
        <section class="portada">
            <div class="portada-circulo"></div>
            <div class="portada-decoracion"></div>

            <div style="max-width: 1280px; margin: 0 auto; padding: 4rem 2rem; position: relative; z-index: 1;">
                <div style="max-width: 640px;">

                    <div class="portada-etiqueta animacion-1">Plataforma agrícola valenciana</div>

                    <h1 class="portada-titulo animacion-2">
                        Del huerto<br>a <span>tu mesa</span>
                    </h1>

                    <p class="portada-subtitulo animacion-3">
                        Compra y vende productos del campo directamente entre agricultores y consumidores. Sin intermediarios, con total confianza.
                    </p>

                    <div class="animacion-4" style="display: flex; gap: 1rem; flex-wrap: wrap;">
                        <a href="/products" class="boton-cta boton-comprar">
                            Quiero comprar
                        </a>
                        <a href="/products" class="boton-cta boton-vender">
                            Quiero vender
                        </a>
                    </div>

                </div>
            </div>
        </section>

        {{-- STATS STRIP --}}
        <section class="franja-estadisticas">
            <div style="max-width: 1280px; margin: 0 auto; padding: 2.5rem 2rem; display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem; text-align: center;">
                <div>
                    <div class="estadistica-numero">100%</div>
                    <div class="estadistica-etiqueta">Productos de origen local</div>
                </div>
                <div style="border-left: 1px solid rgba(255,255,255,0.15); border-right: 1px solid rgba(255,255,255,0.15);">
                    <div class="estadistica-numero">0</div>
                    <div class="estadistica-etiqueta">Intermediarios</div>
                </div>
                <div>
                    <div class="estadistica-numero">24h</div>
                    <div class="estadistica-etiqueta">Gestión de pedidos</div>
                </div>
            </div>
        </section>

        {{-- FEATURES --}}
        <section style="padding: 6rem 2rem;">
            <div style="max-width: 1280px; margin: 0 auto;">

                <div style="text-align: center; margin-bottom: 3.5rem;">
                    <h2 class="fuente-destacada" style="font-size: 2.8rem; font-weight: 700; color: var(--agro-primary); letter-spacing: -0.02em;">
                        ¿Por qué AgroVentas?
                    </h2>
                    <p style="color: var(--agro-muted); font-size: 1.15rem; margin-top: 0.75rem;">Simple, directo y pensado para el campo.</p>
                </div>

                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem;">

                    <div class="caracteristica-tarjeta">
                        <div class="caracteristica-icono">Fresco</div>
                        <div class="caracteristica-titulo">Producto fresco</div>
                        <p class="caracteristica-texto">Conectamos directamente al agricultor con el comprador. El producto llega en su mejor momento.</p>
                    </div>

                    <div class="caracteristica-tarjeta">
                        <div class="caracteristica-icono">Directo</div>
                        <div class="caracteristica-titulo">Trato directo</div>
                        <p class="caracteristica-texto">Sin complicaciones. Habla directamente con quien cultiva y elige lo que necesitas.</p>
                    </div>

                    <div class="caracteristica-tarjeta">
                        <div class="caracteristica-icono">Local</div>
                        <div class="caracteristica-titulo">De tu zona</div>
                        <p class="caracteristica-texto">Apoya a los agricultores de tu comarca. Consume local y contribuye a la economía de tu región.</p>
                    </div>

                </div>
            </div>
        </section>

        {{-- CTA FINAL --}}
        <section style="background: #fff; padding: 5rem 2rem; text-align: center; border-top: 1px solid rgba(0,0,0,0.06);">
            <div style="max-width: 600px; margin: 0 auto;">
                <h2 class="fuente-destacada" style="font-size: 2.5rem; font-weight: 700; color: var(--agro-primary); margin-bottom: 1rem;">
                    Empieza hoy mismo
                </h2>
                <p style="color: var(--agro-muted); font-size: 1.15rem; margin-bottom: 2rem;">
                    Registrarte es gratis y solo lleva un momento.
                </p>
                <a href="/register" class="boton-cta boton-comprar" style="font-size: 1.3rem; padding: 1.2rem 3rem;">
                    Crear cuenta gratis
                </a>
            </div>
        </section>
    </main>

    {{-- FOOTER --}}
    <pie-pagina class="sitio-pie pie-pagina">
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
    </pie-pagina>

</body>
</html>
