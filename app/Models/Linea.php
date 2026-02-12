<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Linea extends Pivot {

    use HasFactory;

    protected $table = 'lineas';

    protected $fillable = [

        'pedido_id', 

        'producto_id', 

        'cantidad', 

        'precio_unitario'

    ];

    public function pedido(): BelongsTo {
        return $this->belongsTo(Pedido::class);
    }

    public function producto(): BelongsTo {
        return $this->belongsTo(Producto::class);
    }
}
