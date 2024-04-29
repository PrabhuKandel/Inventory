<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BranchRequest extends FormRequest
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
    {;

        //using same validation for store and update so if branch is present update else store
        $id =  $this->route('branch') ? $this->route('branch') : null;

        return [
            'name' => 'required|string|unique:offices,name,' . $id,
            'address' => 'required|string',
            'created_date' => 'required',
        ];
    }

    public function messages(): array
    {

        return [

            'name.required' => 'Branch name field can not be empty!',
            'address.required' => "Address field cannot be empty!",
            'created_date.required' => 'Date is required',

        ];
    }
}
