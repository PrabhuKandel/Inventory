<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Middleware\BranchAccessMiddleware;
use App\Models\Contact;
use App\Models\Office;
use App\Models\PurchaseSale;
use App\Models\Transcation;
use App\Models\Warehouse;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public $branch;
    public function __construct(Request $request)
    {

        $this->middleware(BranchAccessMiddleware::class);
        $this->branch = explode("/", $request->route()->uri)[0] == 'branchs' ? $request->route()->parameters['id'] : false;
    }

    public function getData()
    {
        $branch = $this->branch;
        $warehousesNo = $branch ? Warehouse::where('office_id', $branch)->count() : Warehouse::whereNull('office_id')->count();

        $productsNo = Product::count();
        $customersNo = Contact::where('type', 'customer')->count();
        $suppliersNo = Contact::where('type', 'supplier')->count();

        // total purchases and sales till date
        $transactions = PurchaseSale::whereIn('type', ['purchase', 'sale'])
            ->when($branch, function ($query, $branch) {
                return $query->where('office_id', $branch);
            })->when(!$branch, function ($query) {
                return $query->whereNull('office_id');
            })
            ->get();

        $inCount = $transactions->where('type', 'purchase')->count();
        $outCount = $transactions->where('type', 'sale')->count();

        return compact('warehousesNo', 'productsNo', 'customersNo', 'suppliersNo', 'inCount', 'outCount');
    }





    public function branchindex(Request $request)
    {

        $branch = $this->branch;
        //No of warehouses of branch

        $datas = $this->getData();


        return view('administrator.dashboard.branchindex', compact('branch', 'warehousesNo', 'productsNo', 'customersNo', 'suppliersNo', 'inCount', 'outCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function headIndex()
    {
        $branch = $this->branch;
        $products = Product::all();
        $branchs = Office::select('id', 'name')->get();


        $datas = $this->getData();



        return view('administrator.dashboard.headindex', compact('products', 'branchs', 'branch', 'datas'));
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
