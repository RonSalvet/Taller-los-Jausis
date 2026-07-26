<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovimientoInventario extends Model
{
    protected $table = 'movimiento_inventario';
    protected $primaryKey = 'id_movimiento';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = ['id_inventario', 'id_usuario', 'tipo', 'cantidad', 'fecha', 'motivo'];

    public function inventario() { return $this->belongsTo(Inventario::class, 'id_inventario', 'id_inventario'); }
    public function usuario() { return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario'); }
}
