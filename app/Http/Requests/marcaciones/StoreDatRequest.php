<?php

namespace App\Http\Requests\marcaciones;

use Illuminate\Foundation\Http\FormRequest;

class StoreDatRequest extends FormRequest
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
            'archivo' => 'required|file|max:10000|mimes:dat,txt,text/plain,application/octet-stream',
            'establecimiento_id'   => 'required',
        ];
    }

    public function messages()
    {
        return [
            'archivo.required' => 'Archivo Obligatorio',
            'establecimiento_id.required' => 'Establecimiento Obligatorio',
        ];
    }

}