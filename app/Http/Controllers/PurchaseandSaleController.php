<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Warehouse;
use App\Models\PurchaseSale;
use App\Models\Transcation;
use App\Repositories\WarehouseRepository;
use App\Http\Middleware\BranchAccessMiddleware; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PurchaseandSaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct(Request $request)
    {
        $this->branch = explode("/",$request->route()->uri)[0]=='branchs'?$request->route()->parameters['id']:false;
         $this->type = $request->route('type');

    }

    public function index()
    {
        $branch = $this->branch;
        $_type = $this->type=="sales"?"sale":"purchase";
        $purchasesDetails = PurchaseSale::where('office_id',$branch)->orWhereNull('office_id')->where('type',$_type)->get();
        return view('administrator.sale_and-purchase.details',compact('branch','purchasesDetails'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
