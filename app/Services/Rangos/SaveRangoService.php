<?php


namespace App\Services\Rangos;


use App\Models\Rango;

class SaveRangoService
{
    public function __construct(){}

    public function execute($formData)
    {
        $data = Rango::create($formData);
        return $data;
    }
}
