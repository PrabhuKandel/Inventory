@extends('layouts.app')
@section('content')
@php
$edit = isset($user)&&$user?true:false;
@endphp

{{-- create new warehouse branch will be displayed in dropdown --}}
{{-- sucess messaage to when new branch is created --}}
@if($message = Session::get('success'))
<div id="success-message" class="alert alert-success alert-block">
  <strong> {{ $message}}</strong>
</div>
@endif

<div class="form-container  " style="padding-left:0px; margin-top:50px">
  <h3 class="ml-5 mb-3">{{$edit?"Update User Details":"Add New User"}}</h3>
  @if ($errors->any())
  <div class="  alert alert-danger">
    <ul>
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif
  <form class="ml-5 form-group" action="{{$edit?route('users.update',$user->id):route('users.store')}}" method="POST">
    @csrf
    @if($edit)
    @method('PUT')
    @endif
    <div class="form-row ">
      <div class="col-md-4 mb-3">
        <label for="validationDefault01">User name</label>
        <input type="text" class="form-control" id="validationDefault01" placeholder="Enter user name" name="name"
          value="{{$edit?$user->name:old('name')}}">
      </div>

      <div class="col-md-4 mb-3">
        <label for="validationDefault02"> Email</label>
        <input type="text" class="form-control" id="validationDefault02" placeholder="Enter user email" name="email"
          value="{{$edit?$user->email:old('email')}}">
      </div>
      <div class="col-md-4 mb-3" {{$edit?'hidden':""}}>
        <label for="validationDefault02"> Password</label>
        <input type="password" class="form-control" id="validationDefault02" placeholder="Enter user password"
          name="password">
      </div>

      <div class="col-md-4 mb-3">
        <label for="validationDefault02"> address</label>
        <input type="text" class="form-control" id="validationDefault02" placeholder="Enter user address" name="address"
          value="{{$edit?$user->address:old('address')}}">
      </div>
      <div class="col-md-4 mb-3">
        <label for="validationDefault02">Date</label>
        <input type="date" id="date" class="form-control" name="created_date" pattern=""
          value="{{$edit?$user->created_date:""}}" {{$edit?"readonly":''}}>
      </div>
    </div>

    <div class="form-col mt-3">
      <label for="validationDefault02">Select Office </label>
      <div class="col-md-4 mb-3 mr-4">
        <select id="inputState" class="form-control" name="office_id">
          <option value="">Headquarter</option>
          @foreach($offices as $office)
          <option value="{{$office->id}}" {{$edit&&($user->office->id==$office->id)?'selected':''}} > {{$office->name}}
          </option>
          @endforeach
        </select>
      </div>

      <label for="validationDefault02">Select Roles </label>
      <div class="col-md-4 mb-3 mx-2">
        <select id="inputState" class="form-control" name="role_id">
          @foreach ($roles as $role)
          @if($role->name!="Super Admin")
          <option value="{{$role->id}}" {{($edit &&($user->roles[0]->id==$role->id))?'selected':"" }}> {{$role->name}}
          </option>
          @endif
          @endforeach
        </select>
      </div>
    </div>
    <div class="col-md-4 mb-3 d-flex justify-content-center">
      <button class="btn btn-success " type="submit">{{$edit?"Update User":'Add User'}}</button>
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