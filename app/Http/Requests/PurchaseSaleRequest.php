<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseSaleRequest extends FormRequest
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
            'contact_id.*' => 'required',
            'product_id.*' => 'required',
            'warehouse_id.*' => 'required',
            'quantity.*' => 'required|numeric|min:1',
            'total.*' => 'required',
            'created_date' => 'required'
        ];
    }

    public function messages(): array
    {

        return [
            'contact_id.*.required' => "Contact missing at row :index",
            'product_id.*.required' => "Product missing at row :index",
            'warehouse_id.*.required' => "Warehouse missing at row :index",
            'quantity.*.required' => "Quantity missing at row :index",
            'total.*.required' => "Total missing at row :index",
            'created_date.required' => "Please select date ",
            'quantity.*.min' => "Invalid quantity value at row:index ",
        ];
    }
}
