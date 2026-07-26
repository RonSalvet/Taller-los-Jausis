<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdenTrabajo extends Model
{
    protected $table = 'orden_trabajo';
    protected $primaryKey = 'id_orden';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'id_cliente', 'id_vehiculo', 'id_sucursal', 'id_usuario_registro',
        'fecha_ingreso', 'fecha_entrega_estimada', 'estado', 'diagnostico', 'observaciones', 'total',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente', 'id_cliente');
    }

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class, 'id_vehiculo', 'id_vehiculo');
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'id_sucursal', 'id_sucursal');
    }

    public function usuarioRegistro()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario_registro', 'id_usuario');
    }

    public function mecanicos()
    {
        return $this->belongsToMany(Mecanico::class, 'orden_mecanico', 'id_orden', 'id_mecanico')
                     ->withPivot('fecha_asignacion');
    }
}
