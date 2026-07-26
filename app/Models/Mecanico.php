<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mecanico extends Model
{
    protected $table = 'mecanico';
    protected $primaryKey = 'id_mecanico';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = ['id_sucursal', 'nombre', 'ci', 'telefono', 'fecha_contratacion', 'disponibilidad'];

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'id_sucursal', 'id_sucursal');
    }

    public function ordenesTrabajo()
    {
        return $this->belongsToMany(OrdenTrabajo::class, 'orden_mecanico', 'id_mecanico', 'id_orden')
                     ->withPivot('fecha_asignacion');
    }
}
