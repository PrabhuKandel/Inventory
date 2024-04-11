<?php
//for all common
namespace App\Interfaces;
use Illuminate\Http\Request;
interface PurchaseRepositoryInterface
{

public function getAll();
public function getById(string $id);
public function show(string $id);
public function update(Request $request, string $id);
public function store(Request $request ,string $id);

}
