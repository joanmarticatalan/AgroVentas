# Ejemplos de revisiones

## Ejemplo 1: Controlador de autenticación

**Código revisado**:
```php
public function register(Request $request) {
    $request->validate([...]); // 10+ reglas
    $user = User::create([...]);
    Auth::login($user);
    return redirect()->route('todos.productos');
}
```

**Informe**:
- 🟡 **Sugerencia**: Extraer validación a `RegisterRequest` para mantener el controlador legible y permitir reutilización de reglas.
- 🟢 **Opcional**: Tras crear el usuario, considerar enviar evento `Registered` para email de bienvenida.

---

## Ejemplo 2: Vista con relación

**Código revisado**:
```php
// Controlador
$productos = Producto::all();

// Vista
@foreach($productos as $p)
    {{ $p->user->name }}  <!-- N+1: user se carga en cada iteración -->
@endforeach
```

**Informe**:
- 🔴 **Crítico**: N+1 en `Producto::all()`. Usar `Producto::with('user')->get()`.
- 🟡 **Sugerencia**: Aplicar paginación: `Producto::with('user')->paginate(15)`.

---

## Ejemplo 3: Blade inseguro

**Código revisado**:
```blade
<div>{!! $comentario->texto !!}</div>
```

**Informe**:
- 🔴 **Crítico**: `{!! !!}` permite XSS si `texto` viene del usuario. Usar `{{ $comentario->texto }}` o, si necesita HTML, sanitizar con `strip_tags()` o librería HTML Purifier.
