<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <style>
        .bloque { margin-bottom: 20px; padding: 15px; border: 1px solid #ddd; border-radius: 5px; }
        .text-danger { color: red; font-size: 0.9em; }
    </style>
</head>
<body>
    <form action="{{ route('register') }}" method="POST">
        @csrf

        <div>
            <input type="text" name="name" placeholder="Nombre completo" value="{{ old('name') }}" required>
            @error('name') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div>
            <input type="email" name="email" placeholder="Correo electrónico" value="{{ old('email') }}" required>
            @error('email') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div>
            <input type="password" name="password" placeholder="Contraseña" required>
            @error('password') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div>
            <input type="password" name="password_confirmation" placeholder="Repetir contraseña" required>
        </div>

        <div>
            <input type="text" name="telefono" placeholder="Teléfono" value="{{ old('telefono') }}" required>
            @error('telefono') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div>
            <select name="tipoCliente" required>
                <option value="">Selecciona un tipo de cliente</option>
                <option value="comprador" {{ old('tipoCliente') == 'comprador' ? 'selected' : '' }}>Comprador</option>
                <option value="vendedor" {{ old('tipoCliente') == 'vendedor' ? 'selected' : '' }}>Vendedor</option>
                <option value="compraventa" {{ old('tipoCliente') == 'compraventa' ? 'selected' : '' }}>Compra-Venta</option>
            </select>
            @error('tipoCliente') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="bloque">
            <h3> Usar localización existente</h3>
            <select name="localizacion_id">
                <option value="">-- Ninguna (opcional) --</option>
                @foreach($localizaciones as $loc)
                    <option value="{{ $loc->id }}" {{ old('localizacion_id') == $loc->id ? 'selected' : '' }}>
                        {{ $loc->nombreCalle }}, {{ $loc->numero }} ({{ $loc->provincia }})
                    </option>
                @endforeach
            </select>
            @error('localizacion_id') <div class="text-danger">{{ $message }}</div> @enderror
            <p><small>Si seleccionas una, se usará esta. Si no, puedes crear una nueva abajo.</small></p>
        </div>

        <div class="bloque">
            <h3> Crear nueva localización</h3>
            <p>Rellena estos campos solo si quieres crear una nueva dirección.</p>
            
            <div>
                <label>Provincia</label>
                <input type="text" name="nueva_provincia" value="{{ old('nueva_provincia') }}" maxlength="50">
                @error('nueva_provincia') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            
            <div>
                <label>Código Postal (5 dígitos)</label>
                <input type="text" name="nueva_codigoPostal" value="{{ old('nueva_codigoPostal') }}" maxlength="5">
                @error('nueva_codigoPostal') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            
            <div>
                <label>Calle</label>
                <input type="text" name="nueva_nombreCalle" value="{{ old('nueva_nombreCalle') }}" maxlength="50">
                @error('nueva_nombreCalle') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            
            <div>
                <label>Número</label>
                <input type="text" name="nueva_numero" value="{{ old('nueva_numero') }}" maxlength="5">
                @error('nueva_numero') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            
            <div>
                <label>Puerta (opcional)</label>
                <input type="text" name="nueva_puerta" value="{{ old('nueva_puerta') }}" maxlength="10">
                @error('nueva_puerta') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
        </div>

        <button type="submit">Registrarse</button>
    </form>
</body>
</html>