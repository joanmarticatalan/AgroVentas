<footer class="site-footer mt-auto">
    <div class="mx-auto grid max-w-7xl gap-8 px-6 py-10 md:grid-cols-3">
        <div class="flex flex-col gap-3">
            <span class="site-brand text-3xl font-bold">Agro<span class="site-brand-accent">Ventas</span></span>
            <p class="max-w-sm text-base text-green-100/80">Diseño coherente para comprar, vender y gestionar productos agrícolas desde una sola experiencia visual.</p>
        </div>

        <div class="flex flex-col gap-2">
            <span class="text-lg font-semibold text-agro-accent">Accesos</span>
            <a href="{{ route('todos.productos') }}" class="site-footer-link">Explorar productos</a>
            <a href="{{ route('carrito.all') }}" class="site-footer-link">Ver carrito</a>
            @auth
                <a href="{{ route('perfil.editar') }}" class="site-footer-link">Mi perfil</a>
            @else
                <a href="{{ route('register') }}" class="site-footer-link">Crear cuenta</a>
            @endauth
        </div>

        <div class="flex flex-col gap-2">
            <span class="text-lg font-semibold text-agro-accent">Contacto</span>
            <a href="mailto:contacto@agroventas.es" class="site-footer-link">contacto@agroventas.es</a>
            <a href="/aviso-legal" class="site-footer-link">Aviso legal</a>
            <a href="/privacidad" class="site-footer-link">Política de privacidad</a>
        </div>
    </div>

    <div class="border-t border-white/10 py-4 text-center text-sm text-white/45">
        © {{ date('Y') }} AgroVentas. Todos los derechos reservados.
    </div>
</footer>
