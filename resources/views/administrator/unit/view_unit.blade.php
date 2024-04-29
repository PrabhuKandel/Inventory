@extends('layouts.app')
@section('content')
{{-- @dd($branch); --}}
<h3 style="">Unit Details</h3>
<div class="details-container ml-4" style="text-align:center; margin-top:7%">

  <div class="row ">
    <div class="col-sm-3">
      <p class="mb-0 font-weight-bold">Unit Name</p>
    </div>
    <div class="col-sm-9">
      <p class="text-muted mb-0">{{ $unit->name }}</p>
    </div>
  </div>
  <hr class="">
  <div class="row">
    <div class="col-sm-3">
      <p class="mb-0 font-weight-bold">Description</p>
    </div>
    <div class="col-sm-9">
      <p class="text-muted mb-0">{{ $unit->description }}</p>
    </div>
  </div>
  <hr>
  <div class="row">
    <div class="col-sm-3">
      <p class="mb-0 font-weight-bold">Created date</p>
    </div>
    <div class="col-sm-9">
      <p class="text-muted mb-0">{{ $unit->created_date }}</p>
    </div>
  </div>
  <hr>

</div>
@endsection