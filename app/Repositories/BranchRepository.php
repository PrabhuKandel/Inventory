<?php

namespace App\Repositories;
use Illuminate\Http\Request;
use App\Interfaces\BranchRepositoryInterface;
use App\Models\Office;


class BranchRepository  implements BranchRepositoryInterface 
  {

    public function getAll()
    {
      return  Office::all();

    }
    public function getById(string $id)

    {
      return    Office::find($id);

    }

    public function update(Request $request, string $id)
    {

      
      $request->validate([

        'name' => 'required|string',
        'address' => 'required|string',
    ]);
    $office = Office::findorFail($id);
   
  
    $office->name = $request->input('name');
    $office->address = $request->input('address');
       // Save the updated branch record
       $office->save();
       


  }
  public function store(Request $request)
  {
    
    $request->validate([

      'name' => 'required|string|unique:offices',
      'address' => 'required|string',
      'date'=>'required',
 
  ]);
  $office = new Office;
$office->name = $request->name;
$office->address = $request->address;
$office->created_date = $request->date;
 $office->save();
  return true;


}
  }


?>