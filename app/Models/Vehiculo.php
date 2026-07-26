<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    protected $table = 'vehiculo';
    protected $primaryKey = 'id_vehiculo';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = ['id_cliente', 'id_modelo', 'placa', 'anio', 'color', 'nro_chasis', 'kilometraje'];

    public function cliente() { return $this->belongsTo(Cliente::class, 'id_cliente', 'id_cliente'); }
    public function modelo() { return $this->belongsTo(ModeloVehiculo::class, 'id_modelo', 'id_modelo'); }
    public function ordenesTrabajo() { return $this->hasMany(OrdenTrabajo::class, 'id_vehiculo', 'id_vehiculo'); }
}
