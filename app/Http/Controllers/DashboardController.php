<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Middleware\BranchAccessMiddleware;
use App\Models\Contact;
use App\Models\Transcation;
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

    public function index(Request $request)
    {

        $branch = $this->branch;
        //No of warehouses of branch

        $warehousesNo = DB::table('warehouses')
            ->where('office_id', $branch)
            ->orWhereNull('office_id')
            ->count();

        $productsNo = Product::count();
        $customersNo = Contact::where('type', 'customer')->count();
        $suppliersNo = Contact::where('type', 'supplier')->count();

        // total purchases and sales till date
        $transactions = Transcation::whereIn('type', ['in', 'out'])
            ->when($branch, function ($query, $branch) {
                return $query->where('office_id', $branch);
            })->when(!$branch, function ($query) {
                return $query->whereNull('office_id');
            })
            ->get();

        $inCount = $transactions->where('type', 'in')->count();
        $outCount = $transactions->where('type', 'out')->count();

        return view('administrator.dashboard.index', compact('branch', 'warehousesNo', 'productsNo', 'customersNo', 'suppliersNo', 'inCount', 'outCount'));
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
