<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre', 'cargo', 'telefono', 'email', 'estado',
    ];

    public function ordenesServicio()
    {
        return $this->hasMany(OrdenServicio::class);
    }
}
