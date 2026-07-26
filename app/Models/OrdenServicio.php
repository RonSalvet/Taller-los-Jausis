<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenServicio extends Model
{
    use HasFactory;

    protected $table = 'ordenes_servicio';

    protected $fillable = [
        'cliente_id', 'vehiculo_id', 'empleado_id', 'servicio',
        'descripcion', 'estado', 'fecha', 'costo',
    ];

    protected $casts = [
        'fecha' => 'date',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class);
    }

    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }

    public function repuestos()
    {
        return $this->belongsToMany(Repuesto::class, 'orden_repuesto', 'orden_servicio_id', 'repuesto_id')
                     ->withPivot('cantidad', 'precio_unitario')
                     ->withTimestamps();
    }
}
