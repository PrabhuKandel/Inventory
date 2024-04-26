<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Office;
use App\Repositories\ReportRepository;

class ReportController extends Controller
{
    private $reportRepo;

    public function __construct(ReportRepository $reportRepo)
    {
        $this->reportRepo = $reportRepo;
    }

    public function index(Request $request)
    {


        $offices = Office::select('id', 'name')->get();


        $response =  $this->reportRepo->index($request);

        $datas = $response->getdata();
        $reports = $datas->reports;
        $total = $datas->total;
        $totalPages = $datas->totalPages;
        $page = $datas->page;
        $perPage = $datas->perPage;

        if ($request->ajax()) {
            return response()->json(["datas" => $response->getdata(), "success" => true]);
        }

        return view("administrator.report.index", compact('offices', 'reports', 'totalPages', 'page', 'perPage', 'total'));
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