<?php


namespace App\Services\Policias;

use App\Models\Policia;

class FindPoliciaService
{
    public function execute(int $id)
    {
        $policia = Policia::with('rango:id,descripcion')->find($id);
        return $policia;
    }
}
