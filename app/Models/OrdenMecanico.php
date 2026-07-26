<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdenMecanico extends Model
{
    protected $table = 'orden_mecanico';
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = ['id_orden', 'id_mecanico', 'fecha_asignacion'];

}
