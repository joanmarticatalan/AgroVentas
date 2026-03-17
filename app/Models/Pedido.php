<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    /** @use HasFactory<\Database\Factories\PedidoFactory> */
    use HasFactory;
    protected $fillable = ['user_id', 'fecha', 'tipoEnvio', 'localizacion_id', 'precio_total'];

    public function cliente() {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function localizacion(): BelongsTo {
        return $this->belongsTo(Localizacion::class,'localizacion_id');
    }

    public function productos() {
        return $this->belongsToMany(Producto::class, 'lineas')
                ->using(Linea::class) 
                ->withPivot('cantidad', 'precio_unitario')
                ->withTimestamps();
    }
}
