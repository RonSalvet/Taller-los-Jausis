<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MecanicoEspecialidad extends Model
{
    protected $table = 'mecanico_especialidad';
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = ['id_mecanico', 'id_especialidad', 'fecha_certificacion'];

}
