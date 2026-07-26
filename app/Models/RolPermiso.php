<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RolPermiso extends Model
{
    protected $table = 'rol_permiso';
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = ['id_rol', 'id_permiso'];

}
