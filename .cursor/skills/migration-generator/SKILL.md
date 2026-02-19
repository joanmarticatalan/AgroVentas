---
name: migration-generator
description: Genera migraciones de Laravel a partir de una descripción en lenguaje natural (ej. "crear tabla productos con nombre y precio"). Usar cuando el usuario invoque /migration o pida crear una migración a partir de una descripción.
---

# Migration Generator

## Objetivo

Crear archivos de migración de Laravel en `database/migrations/` a partir de una descripción breve (español o inglés). El agente debe interpretar la descripción, elegir tipos de columna adecuados y generar el código listo para ejecutar con `php artisan migrate`.

## Activación

- **Manual**: el usuario escribe `/migration` seguido de la descripción (ej. `/migration crear tabla categorías con nombre y slug`).
- **Conversacional**: cuando el usuario pida explícitamente generar una migración a partir de una descripción.

## Flujo

1. **Interpretar** la descripción: nombre de la tabla (en singular o plural), columnas mencionadas y relaciones si se indican.
2. **Normalizar** nombre de tabla: usar **plural** en inglés/snake_case (ej. "productos" → `productos`, "categorías" → `categorias`).
3. **Mapear** cada campo a tipo Laravel según el nombre o contexto (ver tabla abajo).
4. **Generar** el archivo con nombre `YYYY_MM_DD_HHMMSS_create_<tabla>_table.php` (usar timestamp actual o secuencial).
5. **Incluir** siempre `$table->id()` y `$table->timestamps()` salvo que se indique lo contrario.

## Mapeo descripción → tipo Laravel

| Término / contexto        | Tipo Laravel recomendado     | Notas                    |
|---------------------------|-----------------------------|--------------------------|
| nombre, name, título, slug | `string('nombre', 255)`     | Slug puede ser `->unique()` |
| precio, price, importe     | `decimal('precio', 10, 2)`  |                          |
| cantidad, stock, unidades  | `integer('cantidad')`       |                          |
| fecha, date                | `date('fecha')`             |                          |
| fecha/hora                 | `timestamp('fecha_hora')`   |                          |
| descripción, texto largo   | `text('descripcion')`       |                          |
| email                      | `string('email')->unique()` |                          |
| contraseña, password       | `string('password')`        |                          |
| activo, visible, es_*      | `boolean('activo')`         | default según contexto   |
| imagen, url, enlace        | `string('imagen', 500)`     |                          |
| relación "pertenece a X"   | `foreignId('x_id')->constrained()->onDelete('cascade')` | Tabla referenciada en plural |
| opcional / nullable        | `->nullable()`              |                          |

Si no hay pista clara, usar `string('nombre_campo', 255)` por defecto y documentar en comentario.

## Estructura del archivo generado

- Namespace y `use`: `Illuminate\Database\Migrations\Migration`, `Blueprint`, `Schema`.
- Clase anónima que extiende `Migration`.
- `up()`: `Schema::create('nombre_tabla', function (Blueprint $table) { ... });`
- `down()`: `Schema::dropIfExists('nombre_tabla');`
- Orden típico: `id()`, claves foráneas, campos propios, `timestamps()`.

## Convenciones del proyecto (Laravel)

- Tablas en **plural** (productos, pedidos, users si ya existe).
- Nombres de columnas en **snake_case** (ej. `precio_total`, `localizacion_id`).
- Claves foráneas: `foreignId('user_id')->constrained()` o `->constrained('tabla')` si el nombre no coincide.
- Rutas de migración: `database/migrations/`.

## Ejemplos de entrada → salida

**Entrada**: "crear tabla productos con nombre y precio"

**Salida** (resumen): tabla `productos`, columnas `id`, `nombre` (string), `precio` (decimal 10,2), `timestamps`. Archivo `*_create_productos_table.php`.

**Entrada**: "tabla categorías con nombre, slug único y descripción"

**Salida**: tabla `categorias`, columnas `id`, `nombre`, `slug` (string unique), `descripcion` (text), `timestamps`.

## Modificar tablas existentes

Si la descripción indica "añadir columna X a tabla Y" o "agregar campo X a Y":

- Usar `Schema::table('tabla', function (Blueprint $table) { ... });`
- En `down()` usar `$table->dropColumn('nombre_columna');`
- Nombre de archivo: `*_add_columns_to_<tabla>_table.php` o similar.

## Después de generar

- Indicar al usuario la ruta del archivo creado.
- Recordar ejecutar `php artisan migrate` cuando quiera aplicar los cambios.
