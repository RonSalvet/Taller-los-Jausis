<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModeloVehiculo extends Model
{
    protected $table = 'modelo_vehiculo';
    protected $primaryKey = 'id_modelo';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = ['id_marca', 'nombre', 'tipo_motor', 'cilindrada'];

    public function marca() { return $this->belongsTo(MarcaVehiculo::class, 'id_marca', 'id_marca'); }
    public function vehiculos() { return $this->hasMany(Vehiculo::class, 'id_modelo', 'id_modelo'); }
}
