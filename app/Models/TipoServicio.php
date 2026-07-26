<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoServicio extends Model
{
    protected $table = 'tipo_servicio';
    protected $primaryKey = 'id_tipo_servicio';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = ['nombre', 'descripcion'];

    public function servicios() { return $this->hasMany(Servicio::class, 'id_tipo_servicio', 'id_tipo_servicio'); }
}
