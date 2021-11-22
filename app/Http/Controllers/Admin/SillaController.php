<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AsignacionSillas\AsignacionSillaPorMesaService;
use Illuminate\Http\Request;

class SillaController extends Controller
{
    public function asignacionAPolicia()
    {
        $asignacionSillaPorMesaService = new AsignacionSillaPorMesaService(1);
        $data = $asignacionSillaPorMesaService->execute(1);
        return $data;
    }
}
