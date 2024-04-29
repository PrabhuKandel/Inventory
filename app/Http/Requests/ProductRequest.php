<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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

        $id = (int) $this->route('product') ? $this->route('product') : null;

        return [
            'name' => 'required|unique:products,name,' . $id,
            'rate' => 'required|numeric',
            'category_id' => 'required',
            'unit_id' => 'required',
            'created_date' => 'required',
        ];
    }
    public function messages(): array
    {

        return [

            'name.required' => 'Product name field can not be empty!',
            'rate.required' => "Product rate is required",
            'category_id' => "Please select a category for product.",
            'unit_id.required' => "Please select a unit for product.",
            'created_date.required' => 'Date is required',

        ];
    }
}
