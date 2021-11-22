<?php


namespace App\Services\Rangos;

use App\Models\Rango;

class UpdateRangoService
{
    public function __construct(){}

    public function execute(Rango $rango, array $formData)
    {
        $rango->update(
            $formData
        );

        return true;
    }

}
