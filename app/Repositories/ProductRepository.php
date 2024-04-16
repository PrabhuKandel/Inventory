<?php
namespace App\Repositories;
use App\Models\Product;
use App\Repositories\CommonRepository;
class ProductRepository extends CommonRepository{

  public function __construct(Product $product)
  {
    parent::__construct($product);
  }

}