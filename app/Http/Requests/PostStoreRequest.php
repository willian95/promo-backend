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
            "amount" => "required|integer|min:5",
            "categoryId" => "required|integer",
            "saleDate" => "required|date",
            "price" => "required|numeric",
            "discount1" => "required|numeric",
            "discount2" => "required|numeric",
            "discount3" => "required|numeric",
            "discount4" => "required|numeric",
            "discount5" => "required|numeric",
            "discount6" => "required|numeric",
            "discount7" => "required|numeric",
        ];
    }

    public function messages(){

        return [
            "title.required" => "Titulo es requerido",
            "description.required" => "Descripción es requerida",
            "amount.required" => "Cantidad es requerida",
            "amount.integer" => "Cantidad debe ser un número entero",
            "amount.min" => "La cantidad mínima para publicar son 5 unidades",
            "categoryId.required" => "Categoría es requerida",
            "categoryId.integer" => "Debe seleccionar una categoría válida",
            "saleDate.required" => "Fecha de venta requerida",
            "saleDate.date" => "La fecha de venta debe ser una fecha válida",
            "price.required" => "Precio es requerido",
            "price.numeric" => "Precio debe ser un número",
            "discount1.required" => "Descuento del día 1 es requerido",
            "discount1.numeric" =>  "Descuento del día 1 debe ser un número",
            "discount2.required" => "Descuento del día 2 es requerido",
            "discount2.numeric" =>  "Descuento del día 2 debe ser un número",
            "discount3.required" => "Descuento del día 3 es requerido",
            "discount3.numeric" =>  "Descuento del día 3 debe ser un número",
            "discount4.required" => "Descuento del día 4 es requerido",
            "discount4.numeric" =>  "Descuento del día 4 debe ser un número",
            "discount5.required" => "Descuento del día 5 es requerido",
            "discount5.numeric" =>  "Descuento del día 5 debe ser un número",
            "discount6.required" => "Descuento del día 6 es requerido",
            "discount6.numeric" =>  "Descuento del día 6 debe ser un número",
            "discount7.required" => "Descuento del día 7 es requerido",
            "discount7.numeric" =>  "Descuento del día 7 debe ser un número",

        ];

    }
}
