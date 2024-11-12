<?php

namespace App\Http\Requests\Sagrilaft\Url;

use App\Rules\ValidHttpUrl;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class RequestCreateSagrilaftUrl extends FormRequest
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
            //
            '*' => 'prohibited',
            'descripcion' => 'required|string',
            'tipoValidacion' => 'required|string',
            'urls' => 'array|required',
            'urls.*.url' => ['required', new ValidHttpUrl], // URL requerido
            'urls.*.principal' => 'required|boolean', // Principal requerido
        ];
    }
    public function messages()
    {
        return [
            'descripcion.required' => 'La descripción es obligatoria.',
            'descripcion.string' => 'La descripción debe ser una cadena de texto.',
            'tipoValidacion.required' => 'El tipo de validación es obligatorio.',
            'tipoValidacion.string' => 'El tipo de validación debe ser una cadena de texto.',
            'urls.required' => 'Las URLs son obligatorias.',
            'urls.array' => 'Las URLs deben ser un arreglo.',
            'urls.*.url.required' => 'La URL es obligatoria.',
            'urls.*.url.url' => 'La URL No es Valida.',
            'urls.*.principal.required' => 'El campo principal es obligatorio.',
            'urls.*.principal.boolean' => 'El campo principal debe ser verdadero o falso.',
        ];
    }
    /**
     * Configure the validation for the request.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    protected function prepareForValidation()
    {
        // Asegurarte de que 'urls' es un array, aunque esté vacío
        $this->merge([
            'urls' => $this->input('urls', [])
        ]);

        $this->afterValidation(function (Validator $validator) {
            $urls = $this->input('urls');
            $principalCount = 0;

            foreach ($urls as $url) {
                if ($url['principal']) {
                    $principalCount++;
                }
            }

            if ($principalCount > 1) {
                $validator->errors()->add('urls', 'Solo puede haber una URL principal.');
            } elseif ($principalCount === 0) {
                $validator->errors()->add('urls', 'Debe haber al menos una URL marcada como principal.');
            }
        });
    }


    /**
     * Custom after validation method.
     */
    protected function afterValidation(callable $callback)
    {
        $this->getValidatorInstance()->after($callback);
    }
}
