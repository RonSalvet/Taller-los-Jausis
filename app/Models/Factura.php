<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    protected $table = 'factura';
    protected $primaryKey = 'id_factura';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = ['id_orden', 'numero', 'nit_ci', 'razon_social', 'fecha_emision', 'monto_total', 'estado'];

    public function orden() { return $this->belongsTo(OrdenTrabajo::class, 'id_orden', 'id_orden'); }
    public function pagos() { return $this->hasMany(Pago::class, 'id_factura', 'id_factura'); }
}
