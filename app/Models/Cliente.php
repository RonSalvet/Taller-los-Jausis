<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'cliente';
    protected $primaryKey = 'id_cliente';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = ['nombre', 'ci_nit', 'telefono', 'email', 'direccion', 'fecha_registro', 'estado'];

    public function vehiculos()
    {
        return $this->hasMany(Vehiculo::class, 'id_cliente', 'id_cliente');
    }

    public function ordenesTrabajo()
    {
        return $this->hasMany(OrdenTrabajo::class, 'id_cliente', 'id_cliente');
    }
}
