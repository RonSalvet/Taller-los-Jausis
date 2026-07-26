<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Especialidad extends Model
{
    protected $table = 'especialidad';
    protected $primaryKey = 'id_especialidad';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = ['nombre', 'descripcion'];

    public function mecanicos() { return $this->belongsToMany(Mecanico::class, 'mecanico_especialidad', 'id_especialidad', 'id_mecanico')->withPivot('fecha_certificacion'); }
}
