<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    protected $table = 'cita';
    protected $primaryKey = 'id_cita';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = ['id_cliente', 'id_vehiculo', 'id_sucursal', 'fecha_hora', 'motivo', 'estado'];

    public function cliente() { return $this->belongsTo(Cliente::class, 'id_cliente', 'id_cliente'); }
    public function vehiculo() { return $this->belongsTo(Vehiculo::class, 'id_vehiculo', 'id_vehiculo'); }
    public function sucursal() { return $this->belongsTo(Sucursal::class, 'id_sucursal', 'id_sucursal'); }
}
