<?php
namespace App\Repositories;
use App\Models\User;
use App\Repositories\CommonRepository;
class UserRepository extends CommonRepository{

  public function __construct(User $user)
  {
    parent::__construct($user);
  }

}