<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetodoPago extends Model
{
    protected $table = 'metodo_pago';
    protected $primaryKey = 'id_metodo';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = ['nombre', 'activo'];

    public function pagos() { return $this->hasMany(Pago::class, 'id_metodo', 'id_metodo'); }
}
