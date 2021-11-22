<?php


namespace App\Services\Invitacion;

use App\Models\SillasPolicia;

class ObtenerPoliciasSinInvitacionService
{
    public function execute()
    {
        $data = SillasPolicia::where('codigo_invitacion', '')
            ->with('policia')
            ->orWhereNull('codigo_invitacion')
            ->get();

        return $data;
    }
}
