<?php
//for all common
namespace App\Interfaces;
use Illuminate\Http\Request;
interface SaleRepositoryInterface
{

public function getAll();
public function getById(string $id);
public function show(int $id,Request $request);
public function update(Request $request, string $id);
public function store(Request $request, int $id);

}
