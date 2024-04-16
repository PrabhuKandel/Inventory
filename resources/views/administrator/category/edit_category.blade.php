@extends('layouts.app')
@section('content')
<a href="{{route('categories.index')}}"> <i class="fa-solid fa-arrow-left fa-lg"></i> Go back</a>
@if($message = Session::get('success'))
<div id ="success-message" class="alert alert-success alert-block">
  <strong> {{ $message}}</strong>
</div>
@endif


<div class="form-container  " style="padding-left:100px; margin-top:40px">
  

 
  {{-- category form --}}
<form class="ml-5 form-group" id="categoryForm"  action="{{route('categories.update',$category->id)}}" method="POST" >
  @csrf
  @method('PUT')
  <h3  class=" mb-3">Edit  Category details</h3>
  @if ($errors->any())
    <div class="  alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
  <div class="form-col ">
    <div class="col-md-4 mb-3">
      <label for="validationDefault01">Category name</label>
      <input type="text" class="form-control" id="validationDefault01" placeholder="" value="{{$category->name}}" name="name" >
    </div>
    <div class="col-md-4 mb-3">
      <label for="validationDefault02">Description</label>
      <textarea type="text" class="form-control" id="validationDefault02" placeholder=""  value="" name="description"  style="height: 150px; width: 100%; ">{{$category->description}}</textarea>
    </div>
 
    <div class="col-md-4 mb-3">
      <label for="validationDefault02">Date</label>
      <input type="date" id="categorydate" class="form-control"  value="{{$category->created_date}}" name="created_date" pattern="" readonly >
      
    </div>
    <div class="col-md-4 mb-3 d-flex justify-content-center">
    <button class="btn btn-success " type="submit">Edit Category</button>
    </div>
  </div>
</form>
 
</div>

  

@endsection