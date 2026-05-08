# AGENTS.md

## Objetivo

AgroVentas es una aplicacion Laravel para compraventa de productos agricolas. El proyecto usa Blade en servidor y Vite para los assets.

## Stack

- PHP 8.2+
- Laravel 12
- MySQL
- Vite 7
- Tailwind CSS 4
- Bootstrap 5

## Arquitectura de la web

### Patron general

La aplicacion sigue una arquitectura Laravel clasica MVC, sin capa de servicios separada:

- `routes/web.php` define las rutas HTTP
- Los controladores en `app/Http/Controllers` contienen casi toda la logica de aplicacion
- Los modelos Eloquent en `app/Models` encapsulan tablas y relaciones
- Las vistas Blade en `resources/views` renderizan HTML en servidor
- Vite compila `resources/css/app.css` y `resources/js/app.js`

### Flujo de peticion

1. El navegador llama a una ruta de `routes/web.php`
2. La ruta ejecuta un controlador o devuelve una vista directamente
3. El controlador consulta o persiste datos usando modelos Eloquent
4. El controlador devuelve una vista Blade con arrays o modelos
5. Blade renderiza HTML y carga assets mediante `@vite(...)`

### Donde esta la logica

- No hay repositorios ni servicios dedicados detectados
- El acceso a datos se hace directamente desde controladores con Eloquent
- El carrito usa `session()` y no una tabla propia

## Como arrancar

### Requisitos

- `vendor/` y `node_modules/` deben existir
- Debe existir `.env`
- La base de datos MySQL debe estar accesible con las credenciales del `.env`

### Arranque minimo en local

1. Backend: `php artisan serve`
2. Frontend: `npm run dev`

Abrir la aplicacion en la URL que devuelva `php artisan serve`, normalmente `http://127.0.0.1:8000`.

### Arranque combinado

- `composer run dev`

Esto levanta:
- `php artisan serve`
- `php artisan queue:listen --tries=1`
- `php artisan pail --timeout=0`
- `npm run dev`

### Nota importante

- En este repo no existe `npm run serve`
- El comando correcto para frontend es `npm run dev`

## Que no tocar

- No cambiar `APP_URL` en `.env` a localhost sin confirmacion explicita
- `APP_URL` puede apuntar a `ngrok` porque se usa en despliegue o acceso online
- No asumir que una URL de `ngrok` en `.env` es un error
- No revertir cambios existentes del usuario sin pedirlo
- No borrar assets, datos o configuracion de despliegue para resolver un problema local

## Como probar

### Validacion minima despues de cambios

1. Ejecutar `php artisan test` si el cambio toca logica PHP, rutas, controladores o validaciones
2. Ejecutar `npm run build` si el cambio toca Vite, JS o CSS
3. Si el cambio afecta vistas Blade o flujos web, comprobar manualmente la ruta impactada

### Rutas clave para comprobacion manual

- `/`
- `/products`
- `/infoProducto/{id}`
- `/register`
- `/login`
- `/carro`
- `/misProductos`

### Comprobaciones utiles

- Confirmar que Vite compila sin errores
- Confirmar que Laravel responde sin error 500
- Confirmar que login, registro y CRUD de productos no rompen navegacion basica

## Como se cogen los datos de la base de datos

### Acceso a datos

El proyecto usa Eloquent de forma directa desde controladores. Patrones detectados:

- Lectura simple: `Modelo::all()`, `Modelo::find()`, `Modelo::findOrFail()`
- Filtros: `Modelo::where(...)->get()`
- Relaciones eager loading en algunos puntos: `User::with('localizacion')->get()`, `Pedido::with('cliente')->...`
- Escritura: `Modelo::create([...])`, `$modelo->update([...])`, `$modelo->delete()`

### Ejemplos reales

- `ProductoController::index()` carga productos, usuarios y localizaciones para la vista de listado
- `ProductoController::verinfo($id)` busca un producto y luego su vendedor
- `AuthController::showRegister()` carga localizaciones para el formulario de registro
- `UserController::index()` carga usuarios con su `localizacion`
- `CarritoController` lee productos desde `productos` pero guarda el carrito en sesion, no en MySQL
- `PedidoController::index()` consulta pedidos filtrando por `user_id`

### Modelos y relaciones

- `User` pertenece a `Localizacion` y tiene muchos `Producto` y `Pedido`
- `Producto` pertenece a `User` y a `Localizacion`
- `Pedido` pertenece a `User` y a `Localizacion`
- `Pedido` y `Producto` se relacionan mediante la tabla intermedia `lineas`
- `Localizacion` tiene muchos usuarios, productos y pedidos

## Tablas de la base de datos

### Tablas de dominio

- `users`
- `localizaciones`
- `productos`
- `pedidos`
- `lineas`

### Tablas base de Laravel

- `sessions`
- `password_reset_tokens`
- `jobs`
- `job_batches`
- `failed_jobs`
- `cache`
- `cache_locks`

### Esquema funcional resumido

- `users`
  - columnas base de Laravel: `id`, `name`, `email`, `password`, `remember_token`, timestamps
  - columnas propias: `telefono`, `tipoCliente`, `localizacion_id`
- `localizaciones`
  - `id`, `provincia`, `codigoPostal`, `nombreCalle`, `numero`, `puerta`, timestamps
- `productos`
  - `id`, `user_id`, `nombre`, `variedad`, `stock`, `precio`, `fechaProduccion`, `localizacion_id`, `imagen`, timestamps
- `pedidos`
  - `id`, `user_id`, `fecha`, `tipoEnvio`, `localizacion_id`, `precio_total`, timestamps
- `lineas`
  - `id`, `pedido_id`, `producto_id`, `cantidad`, `precio_unitario`, timestamps

### Relaciones de base de datos

- `users.localizacion_id` -> `localizaciones.id`
- `productos.user_id` -> `users.id`
- `productos.localizacion_id` -> `localizaciones.id`
- `pedidos.user_id` -> `users.id`
- `pedidos.localizacion_id` -> `localizaciones.id`
- `lineas.pedido_id` -> `pedidos.id`
- `lineas.producto_id` -> `productos.id`

## Bugs conocidos

### `app/Http/Controllers/ProductoController.php`

- Falta importar `Illuminate\Support\Facades\Storage`
- `destroy($id)` usa `$producto` antes de inicializarlo
- `index()` carga `Producto::all()`, `Localizacion::all()` y `User::all()`, lo que escala mal con muchos datos

### `app/Http/Controllers/PedidoController.php`

- `validateOrder()` mezcla nombres de clases y campos en ingles (`Product`, `Order`, `Line`, `date`, `total`, `state`) que no coinciden con los modelos y columnas reales del proyecto
- `validateOrder()` usa `$request` pero no lo recibe por parametro
- Hay riesgo alto de que ese metodo no funcione en su estado actual

### Modelos con imports incompletos

- `User` y `Localizacion` declaran retornos `HasMany` pero no importan `Illuminate\Database\Eloquent\Relations\HasMany`

## Estructura de entrada rapida

- `routes/web.php`: rutas principales
- `app/Http/Controllers/AuthController.php`: registro, login y logout
- `app/Http/Controllers/ProductoController.php`: listado, detalle y CRUD de productos
- `resources/views/`: vistas Blade
- `resources/views/inicio.blade.php`: landing principal
- `resources/js/app.js`: entrada JS de Vite
- `resources/css/app.css`: entrada CSS de Vite
- `vite.config.js`: configuracion Vite
- `composer.json`: scripts PHP y comando `composer run dev`
- `package.json`: scripts frontend

## Flujo funcional actual

- `/` renderiza `inicio`
- `/products` lista productos
- `/infoProducto/{id}` muestra detalle de producto
- `/register` y `/login` usan autenticacion propia
- El carrito tiene rutas publicas
- Perfil, pedidos y gestion de productos requieren `auth`
- Gestion de usuarios requiere `auth` y middleware `admin`

## Regla de trabajo para futuras sesiones

- Leer `git status --short` antes de editar
- Preferir cambios pequenos, verificables y con impacto acotado
- Si el objetivo es solo ver el proyecto en local, arrancar servidores sin reconfigurar despliegue
