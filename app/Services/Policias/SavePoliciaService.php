<?php


namespace App\Services\Policias;


use App\Models\Policia;

class SavePoliciaService
{
    public function execute($formData)
    {
        $data = Policia::create($formData);
        return Policia::with('rango:id,descripcion')->where('id', $data->id)->first();
    }
}
