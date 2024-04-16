<?php
namespace App\Repositories;
use App\Models\Office;
use App\Repositories\CommonRepository;
class BranchRepository extends CommonRepository{

  public function __construct(Office $branch)
  {
    parent::__construct($branch);
  }

} 