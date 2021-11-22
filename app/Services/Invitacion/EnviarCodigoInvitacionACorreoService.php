<?php


namespace App\Services\Invitacion;

use App\Services\AsignacionSillas\FindAsignacionCompletaService;

class EnviarCodigoInvitacionACorreoService
{
    public function execute(int $idAsignacionSilla, String $correoDelegado)
    {
        $data = (new FindAsignacionCompletaService())->execute($idAsignacionSilla);
        \Illuminate\Support\Facades\Mail::to($correoDelegado)
            ->send(new \App\Mail\EnviarCodigoInvitacion($data));
    }
}
