<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleRepuesto extends Model
{
    protected $table = 'detalle_repuesto';
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = ['id_detalle', 'id_repuesto', 'cantidad', 'precio_unitario', 'subtotal'];

    public function detalleOrden() { return $this->belongsTo(DetalleOrden::class, 'id_detalle', 'id_detalle'); }
    public function repuesto() { return $this->belongsTo(Repuesto::class, 'id_repuesto', 'id_repuesto'); }
}
