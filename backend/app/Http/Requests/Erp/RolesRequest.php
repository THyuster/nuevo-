<?php

namespace App\Http\Requests\Erp;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class RolesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $usuario = Auth::user();
        return $usuario->administrador == "SI";
        // return false;
    }

    public function rules(): array
    {
        return [
            "*" => "prohibited",
            "id" => "nullable|string",
            "codigo" => "nullable|string",
            "descripcion" => "required|string",
        ];
    }
}
