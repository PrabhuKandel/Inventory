<?php

namespace App\Repositories;

use App\Models\Transcation;
use App\Repositories\CommonRepository;

class TranscationRepository extends CommonRepository
{

  public function __construct(Transcation $transcation)
  {
    parent::__construct($transcation);
  }

  public function calculateAvailability($branch_id, $product_id,  $warehouse_id)
  {

    $total_quantity = Transcation::where('product_id', $product_id)->when($warehouse_id != 0, function ($transcation_query) use ($warehouse_id) {

        return $transcation_query->where('warehouse_id', $warehouse_id);
      })->when($branch_id != 0, function ($transcation_query) use ($branch_id) {

        return $transcation_query->where('office_id', $branch_id);
      })->selectRaw('SUM(CASE WHEN type = "in" THEN quantity ELSE -quantity END) AS total_quantity')
      ->value('total_quantity');
    return $total_quantity;

    //total out 


    /*
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
  return $total_quantity;*/
  }
}
