<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class registeruser extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            '*' => 'prohibited',
            'name' => 'required|string',
            'email' => 'required|string|email',
            'password' => 'required|string',
            'password_confirmation' => 'required|string',
            'grupoEmpresarialId' => 'required|int',
        ];
    }
}
