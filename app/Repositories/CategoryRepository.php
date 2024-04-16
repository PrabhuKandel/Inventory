<?php
namespace App\Repositories;
use App\Models\Category;
use App\Repositories\CommonRepository;
class CategoryRepository extends CommonRepository{

  public function __construct(Category $category)
  {
    parent::__construct($category);
  }

}