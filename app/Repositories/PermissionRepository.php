<?php
namespace App\Repositories;
use Spatie\Permission\Models\Permission;
use App\Repositories\CommonRepository;
class PermissionRepository extends CommonRepository{

  public function __construct(Permission $permission)
  {
    parent::__construct($permission);
  }

}