<?php
namespace App\Repositories;
use App\Interfaces\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
 
class CommonRepository implements RepositoryInterface
{
private $model;
public function __construct(Model $model)
{

$this->model = $model;
}


  public function getAll(){
   

    return $this->model::paginate(5);
  }

  public function find($id){
    return $this->model::findorFail($id);

  }

  public function create(array $data){


  }
  public function store(array $data){
    

    try{ $this->model::create($data); return true;}catch(\Exception $e){   dd($e); return false;}
    
  }

  public function update( array $data,$id){
    $model = $this->model::findorFail($id);
       $model->fill($data);
       $model->save();
       return true;

  }

  public function delete($id){
    try{
      $this->model::where('id',$id)->delete();
   
      return true;
  
  }
  catch(\Exception $e){

    return false;
  }

  }
}