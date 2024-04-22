<?php
namespace App\Repositories;
use Spatie\Permission\Models\Role;
use App\Repositories\CommonRepository;
class RoleRepository extends CommonRepository{

  public function __construct(Role $role)
  {
    parent::__construct($role);
  }

}