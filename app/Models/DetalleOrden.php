<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleOrden extends Model
{
    protected $table = 'detalle_orden';
    protected $primaryKey = 'id_detalle';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = ['id_orden', 'id_servicio', 'cantidad', 'precio_unitario', 'subtotal', 'estado'];

    public function orden() { return $this->belongsTo(OrdenTrabajo::class, 'id_orden', 'id_orden'); }
    public function servicio() { return $this->belongsTo(Servicio::class, 'id_servicio', 'id_servicio'); }
    public function repuestos() { return $this->belongsToMany(Repuesto::class, 'detalle_repuesto', 'id_detalle', 'id_repuesto')->withPivot('cantidad', 'precio_unitario', 'subtotal'); }
}
