<?php

namespace App\Http\Requests\Personal;

use Illuminate\Foundation\Http\FormRequest;

class StorePersonalRequest extends FormRequest
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
            'numero_dni'            => 'required|max:9',
            'nombres'               => 'required|string',
            'apellido_paterno'      => 'required|string',
            'apellido_materno'      => 'required|string',
            'sexo'                  => 'required|string',
            'fecha_nacimiento'      => 'required',
            'estado_civil_id'       => 'required',
            'celular'               => 'required',
            'email'                 => 'required|email',
            'tipo_trabajador_id'    => 'required',
            'tienehijos'            => 'required',
            'profesion_id'          => 'required',
            'cargo_id'              => 'required',
            'nivel_id'              => 'required',
            'sueldo'                => 'required|numeric',
            'condicion_laboral_id'  => 'required',
            'fecha_inicio'          => 'required|date',
            'fecha_fin'             => 'required|date',
            'establecimiento_id'    => 'required',
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