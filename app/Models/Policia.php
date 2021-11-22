<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Policia extends Model
{
    use HasFactory;

    protected $fillable = [
        'cedula',
        'apellido_paterno',
        'apellido_materno',
        'nombres',
        'celular',
        'convencional',
        'correo',
//        'direccion_domicilio',
        'estado',
        'rango_id',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rango()
    {
        return $this->belongsTo(Rango::class);
    }

    public function sillas()
    {
        return $this->belongsToMany(Silla::class, 'sillas_policia')
            ->withPivot(['confirmacion', 'asistencia', 'codigo_invitacion']);
    }


}
