<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Localizacion extends Model
{
    /** @use HasFactory<\Database\Factories\LocalizacionFactory> */
    use HasFactory;
    protected $table = 'localizaciones';
    protected $fillable = ['provincia', 'codigoPostal', 'nombreCalle', 'numero', 'puerta'];

    public function users(): HasMany {
        return $this->hasMany(User::class);
    }

    public function productos(): HasMany {
        return $this->hasMany(Producto::class);
    }
    public function pedidos(): HasMany {
        return $this->hasMany(Pedido::class);
    }
}
