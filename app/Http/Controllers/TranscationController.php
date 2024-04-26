<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transcation;
use App\Http\Middleware\BranchAccessMiddleware;
use App\Repositories\TranscationRepository;

class TranscationController extends Controller
{

    private  $transcationRepo;
    public function __construct(TranscationRepository $transcationRepo)

    {
        $this->transcationRepo = $transcationRepo;
    }


    public function calculateAvailability($branch_id, $product_id,  $warehouse_id)
    {
        $total_quantity = $this->transcationRepo->calculateAvailability($branch_id = 0, $product_id,  $warehouse_id);
        if ($total_quantity) {
            return response()->json(['quantity' => $total_quantity]);
        } else {
            return response()->json(['error' => 'Product not found in the warehouse'], 404);
        }
    }
}
