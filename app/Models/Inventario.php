<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    protected $table = 'inventario';
    protected $primaryKey = 'id_inventario';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = ['id_repuesto', 'id_sucursal', 'stock_actual', 'stock_minimo', 'ubicacion'];

    public function repuesto()
    {
        return $this->belongsTo(Repuesto::class, 'id_repuesto', 'id_repuesto');
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'id_sucursal', 'id_sucursal');
    }

    // true si el stock actual está en o por debajo del mínimo
    public function getStockBajoAttribute(): bool
    {
        return $this->stock_actual <= $this->stock_minimo;
    }
}
