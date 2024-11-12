<?php

namespace App\Http\Requests\Erp\AdminUserRequest;

use Illuminate\Foundation\Http\FormRequest;

class AdminUserRequestUpdateStatusCompanie extends FormRequest
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
    public function rules(): array
    {
        return [
            '*' => 'prohibited',
            'relacion_id' => 'required|array',
            'relacion_id.*' => 'required|integer'
        ];
    }
}
