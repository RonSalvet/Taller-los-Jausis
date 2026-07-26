<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Repuesto extends Model
{
    protected $table = 'repuesto';
    protected $primaryKey = 'id_repuesto';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = ['codigo', 'nombre', 'descripcion', 'marca', 'precio_compra', 'precio_venta'];

    public function inventarios()
    {
        return $this->hasMany(Inventario::class, 'id_repuesto', 'id_repuesto');
    }
}
