<?php

namespace App\Http\Requests\marcaciones;

use Illuminate\Foundation\Http\FormRequest;

class StoreMarcacionRequest extends FormRequest
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
            'numero_dni' => 'required|numeric|digits:8|exists:personales,numero_dni',
            'establecimiento_id' => 'required',
            'fecha_hora' => 'required',
            'tipo' => 'required',
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