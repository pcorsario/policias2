<?php

namespace App\Services\Invitacion;

use App\Models\SillasPolicia;

class ObtenerPoliciasSinConfirmarService
{
    public function execute()
    {
        $data = SillasPolicia::where('confirmacion', 'n')
            ->get();

        return $data;
    }
}
