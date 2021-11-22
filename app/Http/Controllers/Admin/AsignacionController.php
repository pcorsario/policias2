<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveAsignacionRequest;
use App\Models\Silla;
use App\Services\AsignacionSillas\CrearAsignacionService;
use App\Services\AsignacionSillas\FindAsignacionCompletaService;
use Illuminate\Http\Request;

class AsignacionController extends Controller
{
    public function save(SaveAsignacionRequest $request)
    {
        $crearAsignacion = new CrearAsignacionService();
        $findAsignacionCompleta = new FindAsignacionCompletaService();
        $data = $crearAsignacion->execute($request->silla_id, $request->policia_id);
        $data = $findAsignacionCompleta->execute($data->id);
        return response()->json($data);
    }

    public function delete(Silla $silla, Request $request)
    {
        $silla->policias()->detach($request->policia);
        return response()->json([
            'deleted' => true
        ]);
    }

}
