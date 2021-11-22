<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Silla extends Model
{
    use HasFactory;

    protected $fillable = [
        'descripcion',
        'estado',
        'posicion',
        'mesa_id'
    ];

    public function policias()
    {
        return $this->belongsToMany(Policia::class, 'sillas_policia')
            ->withPivot(['id', 'confirmacion', 'asistencia', 'codigo_invitacion']);
    }

    public function asignacionPolicia()
    {
        return $this->hasMany(SillasPolicia::class);
    }
}
