<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Office;
use App\Models\Product;
use App\Models\Warehouse;
use App\Repositories\ReportRepository;

class ReportController extends Controller
{
    private $reportRepo;

    public function __construct(ReportRepository $reportRepo, Request $request)
    {
        $this->reportRepo = $reportRepo;
        // dd($request->route());
    }

    public function index(Request $request)
    {


        $branch = $request->route('id') ? $request->route('id') : false;
        return view("administrator.report.index", compact('branch'));
    }


    public function availabilityReport(Request $request)
    {

        $offices = Office::select('id', 'name')->get();
        $branch = $request->route('id') ? $request->route('id') : false;
        $products = Product::all();

        if ($request->ajax()) {
            $response =  $this->reportRepo->productAvailability($request);
            return response()->json(["datas" => $response->getdata(), "success" => true]);
        }
        return view("administrator.report.availability_report", compact('branch', 'offices', 'products'));
    }



    public function availabilityByWarehouse(Request $request)
    {

        $branch = $request->route('id') ? $request->route('id') : false;
        //if headquarter get all warehouses else warehouses of respective branch
        $warehouses = $branch ? Warehouse::where('office_id', $branch)->get() : Warehouse::all();
        $products = Product::all();

        if ($request->ajax()) {
            $response =  $this->reportRepo->productAvailabilityByWarehouse($request);
            return response()->json(["datas" => $response->getdata(), "success" => true]);
        }


        return view("administrator.report.product_availability_warehouse", compact('warehouses', 'branch', 'products'));
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
