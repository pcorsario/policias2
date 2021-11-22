<?php


namespace App\Services\Rangos;

use App\Models\Rango;

class ListaTodosRangoService
{
    public function __construct()
    {
    }

    public function execute()
    {
        return Rango::get();
    }
}
