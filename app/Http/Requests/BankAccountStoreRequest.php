<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BankAccountStoreRequest extends FormRequest
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
            "bankId" => "required|exists:banks,id",
            "accountNumber" => "required",
            "rut" => "required",
            "email" => "required|email",
            "accountType" => "required"
        ];
    }

    public function messages()
    {
        return [
            "bankId.required" => "Debe seleccionar un banco",
            "bankId.exists" => "Debe seleccionar un banco válido",
            "accountNumber.required" => "Número de cuenta es requerido",
            "rut.required" => "RUT es requerido",
            "email.required" => "Email es requerido",
            "email.email" => "Debes ingresar un email válido",
            "accountType.required" => "Tipo de cuenta es requerido"
        ];
    }
}
