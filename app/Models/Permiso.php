<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    protected $table = 'permiso';
    protected $primaryKey = 'id_permiso';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = ['codigo', 'descripcion', 'modulo'];

    public function roles() { return $this->belongsToMany(Rol::class, 'rol_permiso', 'id_permiso', 'id_rol'); }
}
