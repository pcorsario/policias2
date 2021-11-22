<?php


namespace App\Services\AsignacionSillas;

use Illuminate\Support\Facades\DB;

final class FindAsignacionCompletaService
{
    final public function execute(int $idAsignacion)
    {
        $data = DB::table('sillas_policia as sp')
            ->selectRaw("
                    sp.id as idSP,
                    sp.silla_id as idSilla,
                    sp.policia_id as idPolicia,
                    s.mesa_id as idMesa,
                    m.cuadrante_id as idCuadrante,
                    r.descripcion as rango,
                    p.cedula as cedula,
                    CONCAT(p.apellido_paterno, ' ', IFNULL(p.apellido_materno, ''), ' ', p.nombres) as policia,
                    c.descripcion as cuadrante,
                    m.descripcion as mesa,
                    s.descripcion as silla,
                    sp.codigo_invitacion as codigo_invitacion,
                    sp.confirmacion as confirmacion,
                    sp.asistencia as asistencia
                    ")
            ->join('sillas as s', 's.id', '=', 'sp.silla_id')
            ->join('policias as p', 'p.id', '=', 'sp.policia_id')
            ->join('rangos as r', 'r.id', '=', 'p.rango_id')
            ->join('mesas as m', 'm.id', '=', 's.mesa_id')
            ->join('cuadrantes as c', 'c.id', '=', 'm.cuadrante_id')
            ->where('sp.id', $idAsignacion)
            ->first();

        return $data;
    }
}
