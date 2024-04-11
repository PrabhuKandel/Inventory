@extends('layouts.app')
@section('content')

{{-- create new warehouse branch will be displayed in dropdown --}}
{{-- sucess messaage to when new branch is created --}}
<button class="btn btn-light"><a href="{{route('users.show',1)}}"> <i class="fa-solid fa-arrow-left fa-lg"></i> Go back</a>  </button>
@if($message = Session::get('success'))
<div id ="success-message" class="alert alert-success alert-block">
  <strong> {{ $message}}</strong>
</div>
@endif

<div class="form-container  " style="padding-left:0px; margin-top:50px">
  <h3  class="ml-5 mb-3">Edit user details</h3>
  @if ($errors->any())
    <div class="  alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form class="ml-5 form-group"  action="{{route('users.update',1)}}" method="POST" >
  @csrf
@method('PUT')
  <div class="form-row ">
    <div class="col-md-4 mb-3">
      <label for="validationDefault01">User name</label>
      <input type="text" class="form-control" id="validationDefault01" placeholder="Previuos name will be shown" name="name" >
    </div>

    <div class="col-md-4 mb-3">
      <label for="validationDefault02"> Email</label>
      <input type="text" class="form-control" id="validationDefault02" placeholder="Enter user email" name="email" >
    </div>
  
    <div class="col-md-4 mb-3">
      <label for="validationDefault02"> address</label>
      <input type="text" class="form-control" id="validationDefault02" placeholder="Enter user address" name="address" >
    </div>
    <div class="col-md-4 mb-3">
      <label for="validationDefault02">Date</label>
      <input type="date" id="date" class="form-control" name="date" pattern="" required>
    </div>
  </div>
    
  <div class="form-row mt-3">
    <label for="validationDefault02">Change Branch </label>
    <div class="col-md-4 mb-3 mr-4">
      <select id="inputState" class="form-control" name="branches[]" multiple>
		    <option value="Branch 1"> Branch 1</option>
        <option value="Branch 2">Branch 2</option>
		    <option value="Branch 3"> Branch 3</option>
        <option value="Branch 4">Branch 4</option>
		  </select>
    </div>
      <label for="validationDefault02">Change Roles </label>
      <div class="col-md-4 mb-3 mx-2">
        <select id="inputState" class="form-control" name="role" >
          <option value="role1"> Branch User</option>
          <option value="role2">Branch Admin</option>
          <option value="role3"> Administrator</option>
          <option value="role4">Head Office User</option>
        </select>
      </div>
    </div>
    <div class="col-md-4 mb-3 d-flex justify-content-center">
    <button class="btn btn-success " type="submit">Edit User</button>
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