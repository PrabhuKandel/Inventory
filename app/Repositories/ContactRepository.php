<?php
namespace App\Repositories;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Interfaces\ContactRepositoryInterface;

class ContactRepository implements ContactRepositoryInterface{

  public function getAll()
  {

     return Contact::all();
  }
  public function getById(string $id)
  {
    return Contact::findorFail($id);

  }
  public function update(Request $request, string $id)
  {
    $request->validate([

      'name' => 'required|string|unique:contacts,name,'.$id,
      'address' => 'required|string',
  ]);
  $contact = Contact::findorFail($id);
 

  $contact->name = $request->input('name');
  $contact->address = $request->input('address');
     // Save the updated contact record
     $contact->save();
     return true;
  }
  public function store(Request $request)
  {

      $request->validate([

          'name' => 'required|string|unique:contacts',
          'address' => 'required|string',
          'type'=>'required|string',
          'date'=>'required',
      ]);

      $contact =new Contact([
          'name'=>$request->name,
          'address'=>$request->address,
          'type'=>$request->type,
          'created_date'=>$request->date,

          

      ]);
      $contact->save();
      return true;


  }
  public function delete(string $id)
  {

    try{


      Contact::where('id',$id)->delete();
      return true;
     }
     catch(\Exception $e)
     {
      dd($e);
       return false;
     }
      
  }


}