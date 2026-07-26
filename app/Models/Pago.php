<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $table = 'pago';
    protected $primaryKey = 'id_pago';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = ['id_factura', 'id_metodo', 'id_usuario', 'monto', 'fecha', 'referencia'];

    public function factura() { return $this->belongsTo(Factura::class, 'id_factura', 'id_factura'); }
    public function metodo() { return $this->belongsTo(MetodoPago::class, 'id_metodo', 'id_metodo'); }
    public function usuario() { return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario'); }
}
