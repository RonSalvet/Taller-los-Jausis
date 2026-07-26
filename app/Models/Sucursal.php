<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    protected $table = 'sucursal';
    protected $primaryKey = 'id_sucursal';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = ['nombre', 'direccion', 'telefono', 'zona'];

    public function usuarios() { return $this->hasMany(Usuario::class, 'id_sucursal', 'id_sucursal'); }
    public function mecanicos() { return $this->hasMany(Mecanico::class, 'id_sucursal', 'id_sucursal'); }
    public function ordenesTrabajo() { return $this->hasMany(OrdenTrabajo::class, 'id_sucursal', 'id_sucursal'); }
}
