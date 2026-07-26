<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarcaVehiculo extends Model
{
    protected $table = 'marca_vehiculo';
    protected $primaryKey = 'id_marca';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = ['nombre', 'pais_origen'];

    public function modelos() { return $this->hasMany(ModeloVehiculo::class, 'id_marca', 'id_marca'); }
}
