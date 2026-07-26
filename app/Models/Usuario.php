<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'usuario';
    protected $primaryKey = 'id_usuario';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = ['id_rol', 'id_sucursal', 'nombre_completo', 'email', 'password_hash', 'telefono', 'estado', 'fecha_creacion'];

    public function rol() { return $this->belongsTo(Rol::class, 'id_rol', 'id_rol'); }
    public function sucursal() { return $this->belongsTo(Sucursal::class, 'id_sucursal', 'id_sucursal'); }
}
