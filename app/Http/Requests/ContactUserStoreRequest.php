<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactUserStoreRequest extends FormRequest
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
            "email" => "required|email|unique:contact_users,email",
            "password" => "required|confirmed",
        ];
    }

    public function messages(){
        return [
            "name.required" => "Nombre es requerido",
            "email.required" => "Email es requerido",
            "email.email" => "Email no tiene un formato correcto",
            "email.unique" => "Email ya ha sido registrado",
            "password.required" => "Contraseña es requerida",
            "password.confirmed" => "Contraseñas no coinciden",
        ];
    }
}
