@extends('layouts.app')
@section('content')
<a href="{{route('units.index')}}"> <i class="fa-solid fa-arrow-left fa-lg"></i> Go back</a>
@if($message = Session::get('success'))
<div id ="success-message" class="alert alert-success alert-block">
  <strong> {{ $message}}</strong>
</div>
@endif


<div class="form-container  " style="padding-left:100px; margin-top:40px">
  

 
  {{-- category form --}}
<form class="ml-5 form-group" id="categoryForm"  action="{{route('units.update',$unit->id)}}" method="POST" >
  @csrf
  @method('PUT')
  <h3  class=" mb-3">Edit  Unit details</h3>
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
      <label for="validationDefault01">Unit name</label>
      <input type="text" class="form-control" id="validationDefault01" placeholder="" value="{{$unit->name}}" name="name" >
    </div>
    <div class="col-md-4 mb-3">
      <label for="validationDefault02">Description</label>
      <textarea type="text" class="form-control" id="validationDefault02" placeholder="" name="description"  style="height: 150px; width: 100%; ">{{$unit->description}}</textarea>
    </div>
 
    <div class="col-md-4 mb-3">
      <label for="validationDefault02">Date</label>
      <input type="date" id="unitdate" class="form-control" name="created_date" value="{{$unit->created_date}}" pattern="" readonly >
      
    </div>
    <div class="col-md-4 mb-3 d-flex justify-content-center">
    <button class="btn btn-success " type="submit">Edit Unit</button>
    </div>
  </div>
</form>
 
</div>
<script>
  let today = new Date();

// Format the date as yyyy-mm-dd
let formattedDate = today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2);

// Set the formatted date as the value of the date input
document.getElementById('unitdate').value = formattedDate;


 

 

  </script>
  

@endsection