<?php

namespace App\Models;

use App\Services\Invitacion\EnviarInvitacionACorreo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SillasPolicia extends Model
{
    use HasFactory;

    protected $table = 'sillas_policia';

    protected $fillable = ['silla_id', 'policia_id', 'confirmacion', 'asistencia', 'codigo_invitacion'];

    public function silla()
    {
        return $this->belongsTo(Silla::class);
    }

    public function policia()
    {
        return $this->belongsTo(Policia::class);
    }

    protected static function booted()
    {
        parent::booted();
    }


}
