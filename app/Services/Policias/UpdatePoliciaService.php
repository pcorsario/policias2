<?php


namespace App\Services\Policias;


use App\Models\Policia;

class UpdatePoliciaService
{

    public function execute(Policia $policia, array $formData)
    {
        $policia->update(
            $formData
        );

        return true;
    }
}
