<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mesa extends Model
{
    use HasFactory;

    protected $fillable = [
        'descripcion',
        'estado',
        'cuadrante_id',
        'numero',
        'posicion'
    ];

    public function sillas()
    {
        return $this->hasMany(Silla::class);
    }

    public function cuadrante()
    {
        return $this->belongsTo(Cuadrante::class);
    }

}
