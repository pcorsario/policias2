<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuadrante extends Model
{
    use HasFactory;

    protected $fillable = [
        'descripcion',
        'numero',
        'estado'
    ];

    public function mesas()
    {
        return $this->hasMany(Mesa::class);
    }
}
