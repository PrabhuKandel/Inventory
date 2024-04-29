@extends('layouts.app')
@section('content')
<h3 style="">Role Details</h3>
<div class="details-container ml-4" style=" margin-top:7%">

  <div class="row ">
    <div class="col-sm-3">
      <p class="mb-0 font-weight-bold">Role Name</p>
    </div>
    <div class="col-sm-9">
      <p class="text-muted mb-0">{{$role->name}}</p>
    </div>
  </div>
  <hr class="">
  <div class="row">
    <div class="col-sm-3">
      <p class="mb-0 font-weight-bold">Permissions</p>
    </div>
    <div class="col-sm-9">
      <ul>

        @foreach ($permissions as $permission )
        <li>{{$permission}}</li>
        @endforeach

      </ul>
    </div>
  </div>
  <hr>


</div>
@endsection