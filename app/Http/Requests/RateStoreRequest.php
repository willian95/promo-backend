<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RateStoreRequest extends FormRequest
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
            "comment" => "required",
            "rate" => "required|integer"
        ];
    }

    public function messages()
    {
        return [
            "comment.required" => "Comentario es requerido",
            "rate.required" => "La calificación es requerida",
            "rate.integer" => "Ha ingresado una calificación erronea"
        ];
    }
}
