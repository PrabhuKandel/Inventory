@extends('layouts.app')
@section('content')
@if($message = Session::get('success'))
<div id ="success-message" class="alert alert-success alert-block">
  <strong> {{ $message}}</strong>
</div>
@endif
<a href=""><button class="btn btn-dark  mb-3" type="submit">Go back</button></a>
<div class="form-container  " style="padding-left:100px; margin-top:40px">
  <h3  class="ml-5 mb-3">Edit Role Details</h3>
<form class="ml-5 form-group"  action="{{route('roles.update',$role->id)}}" method="POST" >
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
      <label for="validationDefault01">Role name</label>
      <input type="text" class="form-control" id="validationDefault01" placeholder=""  value="{{$role->name}}" name="name" >
    </div>
   

    <div class="col-md-4 mb-3">
      <label for="validationDefault03">Permissions</label>
      <select id="inputState" class="form-control " name="permissions[]" size="8" multiple>
      @foreach ($permissions as $permission )
        <option   value="{{$permission->id}}"  {{in_array($permission->id,$assignedPermissions)?'selected':''}}   >{{$permission->name}}</option>  
      @endforeach
      
		  </select>
    </div>
    <div class="col-md-4 mb-3 d-flex justify-content-center">
    <button class="btn btn-success " type="submit">Update Role</button>
    </div>
  </div>
</form>
</div>
  <!-- Push section for scripts -->

@endsection