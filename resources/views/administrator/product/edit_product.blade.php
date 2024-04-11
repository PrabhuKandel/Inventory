@extends('layouts.app')
@section('content')
@if($message = Session::get('success'))
<div id ="success-message" class="alert alert-success alert-block">
  <strong> {{ $message}}</strong>
</div>
@endif
<a href="{{route('products.index')}}"><button class="btn btn-dark  mb-3" type="submit">Go back</button></a>
<div class="form-container  " style="padding-left:100px; margin-top:40px">
  <h3  class="ml-5 mb-3">Edit Product Details</h3>
<form class="ml-5 form-group"  action="{{route('products.update',$product->id)}}" method="POST" >
  @csrf
  @method('PUT')
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
      <input type="text" class="form-control" id="validationDefault01" placeholder="" value={{$product->name}} name="name" >
    </div>
    <div class="col-md-4 mb-3">
      <label for="validationDefault02">Rate</label>
      <input type="number" class="form-control" id="validationDefault02" placeholder="" name="rate" value={{$product->rate}} >
    </div>
    <div class="col-md-4 mb-3">
      <label for="validationDefault03">Category</label>
      <select id="inputState" class="form-control" name="category">
        <option  value = "{{$product->category->id}}" selected >{{$product->category->name}}</option>
        @foreach ($categories as $category)
        @if($product->category->id != $category->id)
        <option value="{{$category->id}}"> {{$category->name}}</option>  
          @endif
        @endforeach
		  </select>
    </div>
    <div class="col-md-4 mb-3">
      <label for="validationDefault04">Unit</label>
      <select id="inputState" class="form-control" name="unit">
        <option  value = "{{$product->unit->id}}" selected >{{$product->unit->name}}</option>
        @foreach ($units as $unit)
        @if($product->unit->id != $unit->id)
        <option value="{{$unit->id}}"> {{$unit->name}}</option>  
          @endif
        @endforeach 


		  </select>
    </div>
    <div class="col-md-4 mb-3">
      <label for="validationDefault02"> Created Date</label>
      <input type="date" id="date" class="form-control" name="date" value={{$product->created_date}} pattern="" readonly>
      
    </div>
    <div class="col-md-4 mb-3 d-flex justify-content-center">
    <button class="btn btn-success " type="submit">Edit Product</button>
    </div>
  </div>

 


</form>
</div>
  <!-- Push section for scripts -->
@endsection