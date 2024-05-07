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
    // $warehouse_id = $warehouse_id ? $warehouse_id : 0;

    $total_quantity = Transcation::where('product_id', $product_id)->when($warehouse_id, function ($transcation_query) use ($warehouse_id) {
      return $transcation_query->where('warehouse_id', $warehouse_id);
    })
      ->when($branch_id, function ($transcation_query) use ($branch_id) {
        return $transcation_query->where('office_id', $branch_id);
      })
      ->selectRaw('SUM(CASE WHEN type = "in" THEN quantity ELSE -quantity END) AS total_quantity')
      ->value('total_quantity');

    return $total_quantity;
  }
}
