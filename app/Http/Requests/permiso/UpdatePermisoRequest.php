<?php

namespace App\Http\Requests\permiso;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePermisoRequest extends FormRequest
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
            'personal_id' => 'required',
            'fecha_desde' => 'required|date',
            'hora_inicio' => 'required',
            'fecha_hasta' => 'required|date',
            'hora_hasta' => 'required',
            'tipo_permiso_id' => 'required',
            'motivo' => 'required',
            'establecimiento_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'required' => '* Dato Obligatorio',
            'max' => 'Ingrese Máximo :max caracteres',
            'string' => 'Ingrese caracteres alfanuméricos',
            'number' => 'Ingrese solo numeros',
            'unique' => 'El :email ya existe'
        ];
    }

}