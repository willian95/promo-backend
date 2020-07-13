<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostStoreRequest extends FormRequest
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
            "title" => "required",
            "description" => "required",
            "categoryId" => "required|integer",
            "saleDate" => "required|date",
            "maxDiscount" => "required|numeric|min:20",
            "main_image" => "required",
            "promos" => "required|min:1"
        ];
    }

    public function messages(){

        return [
            "main_image.required" => "Imagen principal es requerida",
            "title.required" => "Titulo es requerido",
            "description.required" => "Descripción es requerida",
            "categoryId.required" => "Categoría es requerida",
            "categoryId.integer" => "Debe seleccionar una categoría válida",
            "saleDate.required" => "Fecha de venta requerida",
            "saleDate.date" => "La fecha de venta debe ser una fecha válida",
            "maxDiscount.required" => "Precio es requerido",
            "maxDiscount.numeric" => "Precio debe ser un número",
            "maxDiscount.min" => "El valor mínimo del porcentage de descuento es de 20%",
            "promos.required" => "Debe tener al menos una promoción",
            "promos.min" => "Debe tener al menos una promoción"

        ];

    }
}
