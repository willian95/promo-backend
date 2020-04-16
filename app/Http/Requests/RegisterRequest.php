<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            "name" => "required",
            "email" => "required|email|unique:users,email",
            "password" => "required|confirmed",
            "locationId" => "required|integer"
        ];
    }

    public function messages(){

        return [
            "name.required" => "Nombre es requerido",
            "email.required" => "Email es requerido",
            "email.email" => "Email debe ser un correo válido",
            "email.unique" => "Este email ya se encuentra registrado",
            "password.required" => "Clave es requerida",
            "locationId.required" => "Comuna es requerida",
            "locationId.integer" => "Debe seleccionar una comuna valida",
        ];

    }
    
}
