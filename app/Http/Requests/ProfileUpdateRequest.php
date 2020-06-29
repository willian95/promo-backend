<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
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
            "commune" => "required|integer",
            "address" => "required"
        ];
    }

    public function messages(){

        return [
            "name.required" => "Nombre es requerido",
            "commune.required" => "Comuna es requerida",
            "commune.integer" => "Debe seleccionar una comuna valida",
            "address.required" => "Dirección de entrega es requerida"
        ];

    }
}
