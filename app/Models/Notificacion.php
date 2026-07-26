<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    protected $table = 'notificacion';
    protected $primaryKey = 'id_notificacion';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = ['id_usuario', 'id_cliente', 'mensaje', 'canal', 'fecha_envio', 'leida'];

    public function usuario() { return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario'); }
    public function cliente() { return $this->belongsTo(Cliente::class, 'id_cliente', 'id_cliente'); }
}
