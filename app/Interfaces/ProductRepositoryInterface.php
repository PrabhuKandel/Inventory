<?php
//for all common
namespace App\Interfaces;
use Illuminate\Http\Request;
interface ProductRepositoryInterface
{

  public function getAll();
  public function getById(string $id);
  public function update(Request $request, string $id);
  public function store(Request $request);
  public function delete(string $id);

}
