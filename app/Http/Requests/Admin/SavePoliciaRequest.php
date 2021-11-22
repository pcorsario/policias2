<?php

namespace App\Http\Requests\Admin;

use App\Rules\Cedula;
use Illuminate\Foundation\Http\FormRequest;

class SavePoliciaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'cedula' => [
                'required',
                'unique:policias',
                'max:10',
                'min:10',
                new Cedula
            ],
            'apellido_paterno' => 'required|max:25',
            'apellido_materno' => 'max:25',
            'nombres' => 'required|max:30',
            'celular' => 'max:10',
            'convencional' => 'max:10',
            'correo' => 'required|email|max:50',
//            'direccion_domicilio' => 'max:150',
            'estado' => 'required|in:a,i',
            'rango_id' => 'required|exists:rangos,id',
        ];
    }
}
