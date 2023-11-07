<?php

namespace App\Http\Requests\Usuario;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'username'              => 'required|unique:users,username,',
            'role_id'               => 'required',
            'establecimiento_id'    => 'required',
            'nombres'               => 'required|string',
            'apellido_paterno'      => 'required|string',
            'apellido_materno'      => 'required|string',
            'numero_dni'            => 'required|string',
            'sexo'                  => 'required|string',
            'celular'               => 'required|numeric|digits:9',
            'email'                 => 'required|email',
        ];
    }

    public function messages()
    {
        return [
            'required' => '* Dato Obligatorio',
            'max' => 'Ingrese Máximo :max caracteres',
            'digits' => 'Ingrese Máximo :digits numeros',
            'string' => 'Ingrese caracteres alfanuméricos',
            'numeric' => 'Ingrese solo numeros',
            'username.unique'    => 'El valor ya existe en la base de datos',
            'email'         => 'No es un email valido'

        ];
    }

}