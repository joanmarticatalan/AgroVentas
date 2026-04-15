<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    /** @use HasFactory<\Database\Factories\PedidoFactory> */
    use HasFactory;

    public const ESTADO_EN_CURSO = 'en_curso';
    public const ESTADO_ENVIADO = 'enviado';
    public const ESTADO_LISTO_RECOGER = 'listo_recoger';

    protected $fillable = ['user_id', 'fecha', 'tipoEnvio', 'estado', 'localizacion_id', 'precio_total'];

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

    public function canTransitionTo(string $estado): bool
    {
        if ($this->estado !== self::ESTADO_EN_CURSO) {
            return false;
        }

        return match ($this->tipoEnvio) {
            'EnvioCasa' => $estado === self::ESTADO_ENVIADO,
            'A recoger' => $estado === self::ESTADO_LISTO_RECOGER,
            default => false,
        };
    }
}
