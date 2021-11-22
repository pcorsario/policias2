<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\Dashboard;
use App\Models\Silla;
use App\Models\SillasPolicia;
use App\Services\AsignacionSillas\FindAsignacionCompletaService;
use App\Services\Invitacion\EnviarCodigoInvitacionACorreoService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InvitacionController extends Controller
{

    private const UNCONFIRMED_INVITATION = 'n';

    public function confirm(string $codigoInvitacion)
    {
        $invitacion = SillasPolicia::where('codigo_invitacion', $codigoInvitacion)->first();

        if ($invitacion->confirmacion !== self::UNCONFIRMED_INVITATION) {
            return redirect()->route('front.policia.index');
        }

        $asignacionPuesto = (new FindAsignacionCompletaService())->execute($invitacion->id);

        return Inertia::render('Invitaciones/Confirmacion', [
            'datosAsignacion' => $asignacionPuesto
        ]);
    }

    public function save(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:sillas_policia',
            'estado' => 'required|in:s,i'
        ]);

        $asignacion = SillasPolicia::find($validated['id']);
        $asignacion->confirmacion = $validated['estado'];
        $asignacion->save();
        (new EnviarCodigoInvitacionACorreoService())->execute($asignacion->id, $asignacion->policia->correo);

        return redirect()->route('front.invitacion.codigo', $asignacion->codigo_invitacion);

    }


    public function codigoInvitacion(string $codigoInvitacion)
    {
        return Inertia::render('Invitaciones/QR', [
            'codigoInvitacion' => $codigoInvitacion
        ]);
    }
}
