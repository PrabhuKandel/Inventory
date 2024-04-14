@extends('layouts.app')
@section('content')
 {{-- sucess messaage to when new branch is created --}}

 {{-- not used currenly --}}
 @if($message = Session::get('success'))
<div id ="success-message" class="alert alert-success alert-block">
  <strong> {{ $message}}</strong>
</div>
@endif

{{-- <button class="btn btn-light"><a href="{{route('warehouses.getWarehousesOfBranch',$branchIn->id)}}"> <i class="fa-solid fa-arrow-left fa-lg"></i> Go back</a>  </button> --}}


<div class="form-container  " style="padding-left:100px; margin-top:70px">
  <h3  class="ml-5 mb-3">Add  New Warehouse</h3>
  @if ($errors->any())
    <div class="  alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form class="ml-5 form-group"  action="{{route('warehouses.store')}}" method="POST" >
  @csrf

  <div class="form-col ">
    <div class="col-md-4 mb-3">
      <label for="validationDefault01">Warehouse name</label>
      <input type="text" class="form-control" id="validationDefault01" placeholder="Enter warehouses name" name="name" >
    </div>
    <div class="col-md-4 mb-3">
      <label for="validationDefault02"> address</label>
      <input type="text" class="form-control" id="validationDefault02" placeholder="Enter warehouses address" name="address" >
    </div>
    <div class="col-md-4 mb-3">
      {{-- <label for="validationDefault02"> Selected Branch</label> --}}
      {{-- <input type="text" class="form-control" id="validationDefault02" placeholder=""  value="{{$branchIn->name}}" readonly > --}}
      <input type="hidden" name="branch" value="{{ $branch ? $branch:''}}">
    </div>
  
    <div class="col-md-4 mb-3">
      <label for="validationDefault02">Date</label>
      <input type="date" id="date" class="form-control" name="date" pattern="" required>
      
    </div>
    <div class="col-md-4 mb-3 d-flex justify-content-center">
    <button class="btn btn-success " type="submit">Create Warehouse</button>
    </div>
  </div>
</form>
</div>

<script>
  let today = new Date();

let formattedDate = today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2);
document.getElementById('date').value = formattedDate;

  </script>
@endsection