<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
        $validation = [
            'email' => ['required', Rule::unique('users','email')->ignore($this->user)],
            'name' => ['required', 'string', 'max:255'],
            'identify' => ['required', 'string', 'max:15', Rule::unique('users','identify')->ignore($this->user)],
            'type' => ['required', 'in:s,a,e,p'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users','email')->ignore($this->user)],
        ];

        //Filled permite saber si algun campo ha sido llamado
        if($this->filled('password'))
        {
            $validation['password'] = ['confirmed', 'min:6'];
        }
        return $validation;
    }
}
