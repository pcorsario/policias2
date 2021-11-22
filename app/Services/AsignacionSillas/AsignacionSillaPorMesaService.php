<?php


namespace App\Services\AsignacionSillas;

use Illuminate\Support\Facades\DB;

class AsignacionSillaPorMesaService
{
    public function execute()
    {
        $data = DB::table('sillas_policia as sp')
            ->selectRaw("
                        sp.id as idSP,
                        s.mesa_id as idMesa,
                        sp.policia_id as idPolicia,
                        sp.silla_id as idSilla,
                        r.descripcion as rango,
                        p.cedula as cedula,
                        CONCAT(p.apellido_paterno, ' ', IFNULL(p.apellido_materno, ''), ' ', p.nombres) as policia,
                        c.descripcion as cuadrante,
                        m.descripcion as mesa,
                        s.descripcion as silla,
                        sp.confirmacion as confirmacion,
                        sp.asistencia as asistencia,
                        sp.codigo_invitacion as invitacion
                        ")
            ->join('sillas as s', 's.id', '=', 'sp.silla_id')
            ->join('policias as p', 'p.id', '=', 'sp.policia_id')
            ->join('rangos as r', 'r.id', '=', 'p.rango_id')
            ->join('mesas as m', 'm.id', '=', 's.mesa_id')
            ->join('cuadrantes as c', 'c.id', '=', 'm.cuadrante_id')
            ->get();
        return $data;
    }
}
