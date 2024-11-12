<?php

namespace App\Http\Requests\Sagrilaft\Empleado;

use Illuminate\Foundation\Http\FormRequest;

class SagrilaftRequestEmpleadoRelUrlCreate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return !!auth()->user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            '*' => 'prohibited',
            'empleadoId' => 'required|string',
            'sagrilaftUrlId' => 'required|string',
            'descripcion' => 'required|string',
            'color' => 'required|string',
            'estado' => 'required|boolean',
            'resources' => 'array|nullable', // Permite que sea un array o nulo
            'resources.*' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048' // Validación para cada archivo en el array
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'estado' => filter_var($this->input('estado'), FILTER_VALIDATE_BOOLEAN),
        ]);
    }

    public function messages()
    {
        return [
            'prohibited' => 'El campo :attribute no es permitido.',
            'required' => 'El campo :attribute es obligatorio',
            'string' => 'El campo :attribute debe ser una cadena de texto',
            'nullable' => 'El campo :attribute es opcional',
            'date' => 'El campo :attribute debe ser una fecha válida.'
        ];
    }
}
