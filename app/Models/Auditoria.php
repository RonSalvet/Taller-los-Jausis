<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Auditoria extends Model
{
    protected $table = 'auditoria';
    protected $primaryKey = 'id_auditoria';
    public $incrementing = true;
    public $timestamps = false;
    protected $casts = ['datos_anteriores' => 'array', 'datos_nuevos' => 'array'];

    protected $fillable = ['id_usuario', 'tabla', 'accion', 'fecha_hora', 'datos_anteriores', 'datos_nuevos'];

    public function usuario() { return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario'); }
}
