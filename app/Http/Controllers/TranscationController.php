<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transcation;
use App\Http\Middleware\BranchAccessMiddleware; 

class TranscationController extends Controller
{
    public function checkQuantity(  $branch_id , $product_id,  $warehouse_id)
    {       
        $product_id = (int) $product_id;
        $warehouse_id = $warehouse_id !== 0 ? (int) $warehouse_id : 0;
        $branch_id = $branch_id !== 0 ? (int) $branch_id : 0;


        // dd($branch_id);
        //get total in quantity
        $query1 = Transcation::where('product_id',$product_id)->where('type','in');
        if ($warehouse_id !== 0) {
            $query1->where('warehouse_id', $warehouse_id);
        }
        if ($branch_id!=0) {
            $query1->where('office_id', $branch_id);
        }
        $total_in_quantity = $query1->sum('quantity');
        //get total out quantity
        $query2 = Transcation::where('product_id',$product_id)->where('type','out');
        if ($warehouse_id !== 0) {
            $query2->where('warehouse_id', $warehouse_id);
        }
        if ($branch_id!=0) {
            $query2->where('office_id', $branch_id);
        }
        $total_out_quantity = $query2->sum('quantity');


         // Calculate the available quantity
    $total_quantity = $total_in_quantity - $total_out_quantity;
    

        if($total_quantity)
        {
            return response()->json(['quantity' => $total_quantity]);
        }
        else
        {
            return response()->json(['error' => 'Product not found in the warehouse'], 404);
        }
           

        }

    }


