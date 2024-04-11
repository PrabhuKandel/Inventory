<?php
namespace App\Interfaces;
use Illuminate\Http\Request;
interface UserRepositoryInterface
{

public function getAll();
public function getById(string $id);

public function update(Request $request, string $id);
public function store(Request $request);

}




