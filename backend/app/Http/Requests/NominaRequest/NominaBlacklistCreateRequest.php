<?php

namespace App\Http\Requests\NominaRequest;

use Illuminate\Foundation\Http\FormRequest;

class NominaBlacklistCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            '*' => 'prohibited',
            'identificacion' => 'required|string|max:30',
            'nombres' => 'required|string|max:50',
            'apellidos' => 'required|string|max:50',
            'observaciones' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'prohibited' => 'El campo :attribute no es permitido.',
            'identificacion.required' => 'El campo identificación es obligatorio.',
            'identificacion.string' => 'El campo identificación debe ser una cadena de caracteres.',
            'identificacion.max' => 'El campo identificación no debe exceder los :max caracteres.',
            'nombres.required' => 'El campo nombres es obligatorio.',
            'nombres.string' => 'El campo nombres debe ser una cadena de caracteres.',
            'nombres.max' => 'El campo nombres no debe exceder los :max caracteres.',
            'apellidos.required' => 'El campo apellidos es obligatorio.',
            'apellidos.string' => 'El campo apellidos debe ser una cadena de caracteres.',
            'apellidos.max' => 'El campo apellidos no debe exceder los :max caracteres.',
            'observaciones.string' => 'El campo observaciones debe ser una cadena de caracteres.',
        ];
    }
}
