---
name: code-reviewer
description: Revisa código PHP/Laravel en busca de errores, malas prácticas y mejoras. Cubre seguridad, Eloquent, convenciones Laravel y calidad. Usar cuando el usuario invoque /review, pida revisión de código o examine cambios en archivos PHP.
---

# Code Reviewer (PHP/Laravel)

## Cuándo aplicar

- Usuario escribe `/review` o pide explícitamente "revisar código"
- Usuario solicita revisión de un archivo, módulo o PR
- Se discuten errores, seguridad o buenas prácticas en PHP/Laravel

## Flujo de revisión

1. **Identificar alcance**: archivo(s) o rutas afectadas
2. **Revisar** según las categorías del checklist
3. **Redactar informe** con el formato de severidad indicado

## Checklist de revisión

### Seguridad
- [ ] Form Requests para validación compleja (no solo `$request->validate()` en controladores)
- [ ] Contraseñas con `Hash::make()` / `bcrypt()`, nunca en texto plano
- [ ] Blade: `{{ }}` para escapar salida; `{!! !!}` solo cuando sea necesario y el contenido sea seguro
- [ ] CSRF en formularios: `@csrf`
- [ ] Autorización: Policies o gates para recursos protegidos (evitar lógica de permisos ad hoc en controladores)

### Eloquent
- [ ] Eager loading con `with()` donde haya relaciones para evitar N+1
- [ ] Relaciones definidas en modelos con nombres claros (`belongsTo`, `hasMany`, etc.)
- [ ] Preferir `where()` sobre `whereRaw()` salvo casos necesarios
- [ ] Consultas complejas encapsuladas en scopes (`scopeActive()`, etc.)
- [ ] `$fillable` o `$guarded` en todos los modelos

### Convenciones Laravel
- [ ] Modelos en `app/Models` con nombre en singular (ej. `User`, `Product`)
- [ ] Controladores en `app/Http/Controllers` con sufijo `Controller`
- [ ] Uso de `route('nombre')` en lugar de URLs hardcodeadas
- [ ] Vistas en `resources/views` con subcarpetas por recurso

### Calidad y buenas prácticas
- [ ] Lógica compleja extraída a Services o Actions (controladores finos)
- [ ] Manejo de errores y casos límite
- [ ] Sin código duplicado; extracción a métodos/helpers reutilizables

## Formato del informe

Clasificar cada hallazgo con:

- 🔴 **Crítico**: Corregir antes de merge (seguridad, bugs graves)
- 🟡 **Sugerencia**: Mejora recomendada (performance, legibilidad, convenciones)
- 🟢 **Opcional**: Mejora secundaria

Estructura del informe:

```markdown
# Revisión de código: [archivo o módulo]

## Resumen
[1-2 frases con el veredicto general]

## Hallazgos

### 🔴 Críticos
- [Hallazgo con archivo/línea y recomendación]

### 🟡 Sugerencias
- [Hallazgo con recomendación]

### 🟢 Opcionales
- [Hallazgo]

## Acciones recomendadas
1. [Prioridad alta]
2. [Prioridad media]
```

## Ejemplo de feedback

**Entrada**: Controlador con validación inline y sin Policy.

**Salida**:
```markdown
### 🔴 Críticos
- **AuthController.php, línea 23**: Mover validación a Form Request (`RegisterRequest`) para mantener el controlador limpio y reutilizar reglas.
- **ProductoController.php**: No hay Policy; cualquier usuario podría editar productos. Crear `ProductoPolicy` y usar `$this->authorize()`.

### 🟡 Sugerencias
- **AuthController.php, línea 14**: `Localizacion::all()` puede ser costoso. Usar cache o scope si la lista crece.
```

## Recursos adicionales

- Criterios detallados de seguridad: [reference.md](reference.md)
- Ejemplos de revisiones completas: [examples.md](examples.md)
