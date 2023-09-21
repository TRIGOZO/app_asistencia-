<?php

namespace App\Http\Requests\marcacionesvshorario;

use Illuminate\Foundation\Http\FormRequest;

class BuscarMarcacionesvsHorarioRequest extends FormRequest
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
            'dni' => 'required|numeric|digits:8|exists:personales,numero_dni',
            'mes' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'required' => '* Dato Obligatorio',
            'max' => 'Ingrese Máximo :max caracteres',
            'string' => 'Ingrese caracteres alfanuméricos',
            'number' => 'Ingrese solo numeros',
            'numeric'  => 'Solo Numeros',
            'unique' => 'El :nombre ya existe',
            'digits'  => 'Maximo :digits digitos',
            'exists'    => 'El DNI del personal no existe'
        ];
    }

}