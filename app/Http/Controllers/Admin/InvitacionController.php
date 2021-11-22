<?php

namespace App\Http\Controllers\Admin;

use App\Exports\EventoExport;
use App\Http\Controllers\Controller;
use App\Models\SillasPolicia;
use App\Services\AsignacionSillas\AsignacionSillaPorMesaService;
use App\Services\AsignacionSillas\FindAsignacionCompletaService;
use App\Services\Invitacion\EnviarInvitacionACorreo;
use App\Services\Invitacion\GenerarCodigoInvitacionService;
use App\Services\Invitacion\ObtenerPoliciasSinInvitacionService;
use App\Services\Invitacion\ObtenerPoliciasSinConfirmarService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class InvitacionController extends Controller
{
    public function index()
    {
        $asignacionSillaPorMesaService = new AsignacionSillaPorMesaService();
        $asignaciones = $asignacionSillaPorMesaService->execute();

        return Inertia::render('Invitaciones/Index', compact('asignaciones'));
    }

    public function save(Request $request)
    {

        $asignaciones = SillasPolicia::whereIn('id', array_column(($request->invitaciones), 'idSP'))->get();
        $generarCodigoInvitacionService = new GenerarCodigoInvitacionService();

        foreach ($asignaciones as $asignacion) {
            $asignacion->codigo_invitacion = $generarCodigoInvitacionService->execute();
            $asignacion->save();
        }
    }

    /**
     * Permite enviar todas las invitaciones a todos los delegados
     * que no posean invitaciones
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function enviarTodas(Request $request)
    {
        $policiasSinInvitacion = (new ObtenerPoliciasSinInvitacionService())->execute();
        $generarCodigoInvitacionService = new GenerarCodigoInvitacionService();

        foreach ($policiasSinInvitacion as $invitacion)
        {
            $invitacion->codigo_invitacion = $generarCodigoInvitacionService->execute();
            $invitacion->save();
            (new EnviarInvitacionACorreo())->execute($invitacion->id, $invitacion->policia->correo);
        }

        return redirect()->back();

    }

    public function reenviar()
    {
        $invitacionesSinConfirmar = (new ObtenerPoliciasSinConfirmarService())->execute();
        $enviarInvitacionACorreo = new EnviarInvitacionACorreo();

        foreach ($invitacionesSinConfirmar as $invitacion)
        {
            $enviarInvitacionACorreo->execute($invitacion->id, $invitacion->policia->correo);
        }

        return redirect()->back();
    }

    public function escanearCodigoQR()
    {
        return Inertia::render('Invitaciones/Escanear');
    }

    public function obtenerDatosInvitacion(String $codigoInvitacion)
    {
        $sillasPolicia = SillasPolicia::where('codigo_invitacion', $codigoInvitacion)->firstOrFail();
        $datosCompletosInvitacion = (new FindAsignacionCompletaService)->execute($sillasPolicia->id);
        return $datosCompletosInvitacion;
    }

    public function confirmarAsistencia(Request $request)
    {
        $asignacion = SillasPolicia::findOrFail($request->id);
        $asignacion->asistencia = 's';
        $asignacion->save();

        return response()->json([
            'status' => 'success'
        ]);
    }

    public function exportar()
    {
        return Excel::download(new EventoExport(), 'asistencias.xlsx');
    }

    public function exportarPDF()
    {
        $estadoConfirmacion = [
            's' => 'Si',
            'n' => 'No',
            'i' => 'Rechazada'
        ];

        $estadoAsistencia = [
            's' => 'Asistió',
            'n' => 'No asistió'
        ];

        $invitaciones = (new AsignacionSillaPorMesaService)->execute();
        $pdf = \PDF::loadView('pdf.listado-invitaciones', compact(
            'invitaciones', 'estadoConfirmacion', 'estadoAsistencia'))->setPaper('a4', 'landscape');
        return $pdf->download('listado-invitaciones.pdf');
    }

    public function reporteListado()
    {
        $invitados = (new AsignacionSillaPorMesaService)->execute();
        $pdf = \PDF::loadView('pdf.listado-asistentes', compact('invitados'));
        return $pdf->download('listado-asistentes.pdf');
    }

}
