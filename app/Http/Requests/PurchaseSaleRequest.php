<?php

namespace App\Http\Requests;

use App\Repositories\TranscationRepository;
use Illuminate\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseSaleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public $transcationRepo;
    public $branch;
    public function __construct(TranscationRepository $transcationRepo, Request $request)
    {
        $this->transcationRepo = $transcationRepo;
        $this->branch = explode("/", $request->route()->uri)[0] == 'branchs' ? $request->route()->parameters['id'] : false;
    }

    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(Request $request): array
    {
        $type = $request->route('type');
        $arr = [];

        return [
            'contact_id' => 'required',
            'product_id.*' => 'required',
            'warehouse_id.*' => 'required',
            'quantity.*' => ['required', 'numeric', 'min:1', $type == 'sales' ? function ($attribute, $value, $fail) use ($arr) {






                //getting index since quantity.0 and index is 0
                $parts = explode('.', $attribute);
                $index = (int) end($parts);
                $requestedQuantity = 0;

                $branch = $this->branch;

                $quantites = $this->input('quantity', []);
                $products = $this->input('product_id', []);
                $warehouses = $this->input('warehouse_id', []);
                // Get the availability for this index
                if (in_array($index, $arr)) {
                    return;
                }

                $availableQuantity = $this->transcationRepo->calculateAvailability($branch ? $branch : 0, $products[$index], $warehouses[$index]);
                //checking if given product validation already failed or not if failed no need to check again

                //looping  through all products quantities and checking their validations
                for ($i = $index; $i < count($products); $i++) {
                    //checking if there is any product with same warehouse ,if so then requested quantity is added
                    if ($products[$i] == $products[$index] && $warehouses[$i] == $warehouses[$index]) {
                        $requestedQuantity += $quantites[$i];
                    }
                    if ($requestedQuantity > $availableQuantity) {
                        //inserting validation failed index in array so that no need to check again
                        $arr[] = $i;
                        $fail("The quantity at row " . $i + 1 . " exceeds the available quantity ");
                        return;
                    }
                }
            } : null],
            'total.*' => 'required',
            'created_date' => 'required'
        ];
    }

    public function messages(): array
    {

        return [
            'contact_id.required' => "Contact is required",
            'product_id.*.required' => "Product missing at row :index",
            'warehouse_id.*.required' => "Warehouse missing at row :index",
            'quantity.*.required' => "Quantity missing at row :index",
            'total.*.required' => "Total missing at row :index",
            'created_date.required' => "Please select date ",
            'quantity.*.min' => "Invalid quantity value at row:index ",
        ];
    }
}
