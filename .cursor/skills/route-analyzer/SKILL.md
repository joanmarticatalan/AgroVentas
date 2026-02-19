---
name: route-analyzer
description: Lista y analiza las rutas definidas en Laravel, mostrando controladores y middleware. Usar cuando el usuario invoque /routes o pida listar, analizar o revisar las rutas de la aplicación.
---

# Route Analyzer

## Cuándo aplicar

- Usuario escribe `/routes` o pide "listar rutas", "analizar rutas", "ver rutas"
- Usuario quiere conocer controladores o middleware asociados a las rutas
- Revisión de estructura de routing de la aplicación

## Flujo de análisis

1. **Obtener rutas**: ejecutar `php artisan route:list --json` (o `php artisan route:list` si falla)
2. **Alternativa si falla**: leer `routes/web.php` y `routes/api.php` y parsear controladores/middleware manualmente
3. **Presentar** en el formato indicado

## Comandos recomendados

```bash
# JSON estructurado (preferido)
php artisan route:list --json

# Tabla legible
php artisan route:list --sort=uri

# Filtrar por middleware
php artisan route:list --middleware=auth

# Solo rutas de la app (excluir vendor)
php artisan route:list --except-vendor
```

## Formato del informe

Estructura sugerida para la salida:

```markdown
# Análisis de rutas: [Nombre del proyecto]

## Resumen
- **Total rutas**: X
- **Controladores**: [lista de controladores únicos]
- **Middleware globales**: [si aplica]

## Rutas por grupo

### Públicas (sin auth)
| Método | URI | Nombre | Controlador/Action |
|--------|-----|--------|--------------------|
...

### Protegidas (con middleware)
| Método | URI | Nombre | Middleware | Controlador |
...
```

## Análisis a incluir

- **Controladores**: extraer de la columna `action` (formato `App\Http\Controllers\X@method`)
- **Middleware**: columna `middleware` del JSON o del array de la ruta
- **Rutas sin nombre**: indicar cuáles no tienen `->name()` para sugerir mejora
- **Controladores inexistentes**: si `route:list` falla por clase no encontrada, señalar la ruta problemática

## Fallback: análisis manual de archivos

Si `route:list` falla (ej. controlador no importado o inexistente):

1. Leer `routes/web.php` y `routes/api.php`
2. Usar grep para buscar: `->middleware(`, `Controller::class`, `->name(`
3. Inferir controladores y middleware del código
4. Añadir advertencia sobre el error que impidió `route:list`

## Ejemplo de salida

```markdown
# Análisis de rutas: AgroVentas

## Resumen
- **Total rutas**: 14
- **Controladores**: AuthController, ProductoController, CarritoController

## Rutas principales
| Método | URI | Nombre | Action |
|--------|-----|--------|--------|
| GET | / | - | Closure |
| GET | /products | todos.productos | ProductoController@index |
| GET | /login | login | AuthController@showLogin |
...
```
