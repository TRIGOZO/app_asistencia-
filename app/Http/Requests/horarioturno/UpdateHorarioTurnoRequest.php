<?php

namespace App\Http\Requests\horarioturno;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHorarioTurnoRequest extends FormRequest
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
            'tipo_turno_id' => 'required',
            'horaentrada' => 'required',
            'horasalida' => 'required',
            'toleranciaantes' => 'required',
            'toleranciadespues' => 'required',
            'inicioentrada' => 'required',
            'finentrada' => 'required',
            'iniciosalida' => 'required',
            'finsalida' => 'required',
            'dialunes' => 'required',
            'diamartes' => 'required',
            'diamiercoles' => 'required',
            'diajueves' => 'required',
            'diaviernes' => 'required',
            'diasabado' => 'required',
            'diadomingo' => 'required',
            'totalhoras' => 'required',
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