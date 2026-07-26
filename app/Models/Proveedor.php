<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'proveedor';
    protected $primaryKey = 'id_proveedor';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = ['razon_social', 'nit', 'telefono', 'email', 'direccion'];

    public function repuestos() { return $this->belongsToMany(Repuesto::class, 'proveedor_repuesto', 'id_proveedor', 'id_repuesto')->withPivot('precio_referencial'); }
}
