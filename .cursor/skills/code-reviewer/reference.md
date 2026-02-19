# Criterios detallados de revisión

## Seguridad (detalle)

| Práctica | ✅ Correcto | ❌ Evitar |
|----------|-------------|-----------|
| Validación | Form Request para formularios complejos | Validación larga inline en controlador |
| Contraseñas | `Hash::make($request->password)` | `$request->password` directo en BD |
| Blade | `{{ $variable }}` (escapa HTML) | `{!! $html !!}` con input de usuario |
| CSRF | `@csrf` en formularios POST/PUT/DELETE | Formularios sin token |
| Autorización | `$this->authorize('update', $model)` | `if ($user->id === $model->user_id)` en controlador |

## Eloquent (detalle)

**N+1**: Si en una vista/iteración se accede a `$item->relacion->campo`, la relación debe cargarse con `with('relacion')` en la consulta origen.

**Scopes**: Para filtros reutilizables, definir `scopeActivos($query)` y usar `Modelo::activos()->get()`.

**whereRaw**: Solo cuando las expresiones SQL no tienen equivalente en el Query Builder (ej. funciones de BD).

## Convenciones de rutas

- Web: `routes/web.php` con nombre `route('nombre.ruta')`
- API: `routes/api.php` con prefijo `/api`
- No hardcodear `/productos/123`; usar `route('productos.show', $producto)`
