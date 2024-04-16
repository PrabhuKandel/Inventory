<?php
namespace App\Repositories;
use App\Models\Unit;
use App\Repositories\CommonRepository;
class UnitRepository extends CommonRepository{

  public function __construct(Unit $unit)
  {
    parent::__construct($unit);
  }

}