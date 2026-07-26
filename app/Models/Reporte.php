<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reporte extends Model
{
    protected $table = 'reporte';
    protected $primaryKey = 'id_reporte';
    public $incrementing = true;
    public $timestamps = false;
    protected $casts = ['parametros' => 'array'];

    protected $fillable = ['id_usuario', 'tipo', 'fecha_generacion', 'parametros'];

    public function usuario() { return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario'); }
}
