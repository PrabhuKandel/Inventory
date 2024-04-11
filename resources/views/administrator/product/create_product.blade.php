@extends('layouts.app')
@section('content')
@if($message = Session::get('success'))
<div id ="success-message" class="alert alert-success alert-block">
  <strong> {{ $message}}</strong>
</div>
@endif
<a href="{{route('products.index')}}"><button class="btn btn-dark  mb-3" type="submit">Go back</button></a>
<div class="form-container  " style="padding-left:100px; margin-top:40px">
  <h3  class="ml-5 mb-3">Enter Product Details</h3>
<form class="ml-5 form-group"  action="{{route('products.store')}}" method="POST" >
  @csrf
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
      <label for="validationDefault01">Product name</label>
      <input type="text" class="form-control" id="validationDefault01" placeholder="Enter product name" name="name" >
    </div>
    <div class="col-md-4 mb-3">
      <label for="validationDefault02">Rate</label>
      <input type="number" class="form-control" id="validationDefault02" placeholder="Enter rate of product" name="rate" >
    </div>
    <div class="col-md-4 mb-3">
      <label for="validationDefault03">Category</label>
      <select id="inputState" class="form-control" name="category">
        <option selected disabled>Select Category</option>
        @foreach ($categories as $category )
        <option value="{{$category->id}}"> {{$category->name}}</option>
        @endforeach
		  </select>
    </div>
    <div class="col-md-4 mb-3">
      <label for="validationDefault04">Unit</label>
      <select id="inputState" class="form-control" name="unit">
        <option selected disabled>Select Unit</option>
        @foreach ($units as $unit )
        <option value="{{$unit->id}}"> {{$unit->name}}</option>
        @endforeach
      


		  </select>
    </div>
    <div class="col-md-4 mb-3">
      <label for="validationDefault02">Date</label>
      <input type="date" id="date" class="form-control" name="date" pattern="" >
      
    </div>
    <div class="col-md-4 mb-3 d-flex justify-content-center">
    <button class="btn btn-success " type="submit">Create Product</button>
    </div>
  </div>

 


</form>
</div>
  <!-- Push section for scripts -->

  <script>
  var today = new Date();

// Format the date as yyyy-mm-dd
var formattedDate = today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2);

// Set the formatted date as the value of the date input
document.getElementById('date').value = formattedDate;

  </script>
  


@endsection