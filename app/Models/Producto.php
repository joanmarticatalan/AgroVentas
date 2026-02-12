<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    /** @use HasFactory<\Database\Factories\ProductoFactory> */
    use HasFactory;

    protected $fillable = ['user_id', 'nombre', 'variedad', 'fechaProduccion', 'localizacion_id', 'imagen'];

    public function vendedor() {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function localizacion(): BelongsTo {
        return $this->belongsTo(Localizacion::class);
    }

    public function pedidos() {
        return $this->belongsToMany(Pedido::class, 'pedido_producto')
                ->using(Linea::class) 
                ->withPivot('cantidad', 'precio_unitario')
                ->withTimestamps();
    }

}
