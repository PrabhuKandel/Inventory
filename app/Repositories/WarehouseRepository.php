<?php
namespace App\Repositories;
use App\Models\Warehouse;
use App\Repositories\CommonRepository;
class WarehouseRepository extends CommonRepository{

  public function __construct(Warehouse $warehouse)
  {
    parent::__construct($warehouse);
  }

}