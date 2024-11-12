<?php

namespace App\Http\Requests\modulo_contabilidad;

use Illuminate\Foundation\Http\FormRequest;

class ReceiptValidation extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {

        return [
            'codigo' => 'required|string',
            'descripcion' => 'required|string',
          
        ];
    }
    public function messages()
    {
        return [
            'codigo.required' => 'El campo Código es obligatorio.',
            'descripcion.required' => 'El campo Descripción es obligatorio.',
        ];
    }
}
