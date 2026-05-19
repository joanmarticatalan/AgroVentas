<footer class="sitio-pie mt-auto">
    <div class="mx-auto grid max-w-7xl gap-8 px-6 py-10 md:grid-cols-3">
        <div class="flex flex-col gap-3">
            <span class="sitio-marca text-3xl font-bold">Agro<span class="sitio-marca-acento">Ventas</span></span>
            <p class="max-w-sm text-base text-green-100/80">Del huerto a casa.</p>
        </div>

        <div class="flex flex-col gap-2">
            <span class="text-lg font-semibold text-agro-accent">Accesos</span>
            <a href="{{ route('todos.productos') }}" class="sitio-pie-enlace">Explorar productos</a>
            <a href="{{ route('carrito.all') }}" class="sitio-pie-enlace">Ver carrito</a>
            @auth
                <a href="{{ route('perfil.editar') }}" class="sitio-pie-enlace">Mi perfil</a>
            @else
                <a href="{{ route('register') }}" class="sitio-pie-enlace">Crear cuenta</a>
            @endauth
        </div>

        <div class="flex flex-col gap-2">
            <span class="text-lg font-semibold text-agro-accent">Contacto</span>
            <a href="mailto:contacto@agroventas.es" class="sitio-pie-enlace">contacto@agroventas.es</a>
            <a href="/aviso-legal" class="sitio-pie-enlace">Aviso legal</a>
            <a href="/privacidad" class="sitio-pie-enlace">Política de privacidad</a>
        </div>
    </div>

    <div class="border-t border-white/10 py-4 text-center text-sm text-white/45">
        © {{ date('Y') }} AgroVentas. Todos los derechos reservados.
    </div>
</footer>
