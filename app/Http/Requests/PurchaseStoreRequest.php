<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseStoreRequest extends FormRequest
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
            "amount" => "required|integer",
            "transfer" => "required",
            "bank" => "required|integer"
        ];
    }

    public function messages(){

        return [
            "amount.required" => "Cantidad es requerida",
            "amount.integer" => "Cantidad es requerida",
            "transfer.required" => "Id de transferencia es requerido",
            "bank.required" => "Banco es requerido",
            "bank.integer" => "Debe seleccionar un banco válido"
        ];

    }
}
