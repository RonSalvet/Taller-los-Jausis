<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $table = 'servicio';
    protected $primaryKey = 'id_servicio';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = ['id_tipo_servicio', 'nombre', 'descripcion', 'precio_base', 'tiempo_estimado', 'estado'];

    public function tipoServicio() { return $this->belongsTo(TipoServicio::class, 'id_tipo_servicio', 'id_tipo_servicio'); }
}
