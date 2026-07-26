<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProveedorRepuesto extends Model
{
    protected $table = 'proveedor_repuesto';
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = ['id_proveedor', 'id_repuesto', 'precio_referencial'];

}
