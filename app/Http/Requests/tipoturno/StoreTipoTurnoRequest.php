<?php

namespace App\Http\Requests\tipoturno;

use Illuminate\Foundation\Http\FormRequest;

class StoreTipoTurnoRequest extends FormRequest
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
            'nombre'               => 'required|string|unique:tipo_turnos,nombre',
            'diastolerancia'        => 'required',
            'descuento'     => 'required',
            'guardia'       => 'required',
            'permiso'       => 'required',
            'horasantesdescansa'        => 'required',
            'horasdespuesdescansa'      => 'required',
            'horaasistencial'       => 'required',
            'horaadministrativo'        => 'required',
            'nroturnos'     => 'required',
        ];
    }

    public function messages()
    {
        return [
            'required' => '* Dato Obligatorio',
            'max' => 'Ingrese Máximo :max caracteres',
            'string' => 'Ingrese caracteres alfanuméricos',
            'number' => 'Ingrese solo numeros',
            'unique' => 'El :nombre ya existe'
        ];
    }

}