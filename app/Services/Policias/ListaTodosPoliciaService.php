<?php


namespace App\Services\Policias;

use App\Models\Policia;

class ListaTodosPoliciaService
{
    public function __construct()
    {

    }

    public function exectue()
    {
        return Policia::with('rango:id,descripcion')->get();
    }
}
