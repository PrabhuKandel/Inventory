@extends('layouts.app')
@section('content')
{{-- @dd($branch); --}}
<h3 style="">Product Details</h3>
<div class="details-container ml-4" style="text-align:center; margin-top:7%">

  <div class="row ">
    <div class="col-sm-3">
      <p class="mb-0 font-weight-bold">Product Name</p>
    </div>
    <div class="col-sm-9">
      <p class="text-muted mb-0">{{$product->name}}</p>
    </div>
  </div>
  <hr class="">
  <div class="row">
    <div class="col-sm-3">
      <p class="mb-0 font-weight-bold">Rate</p>
    </div>
    <div class="col-sm-9">
      <p class="text-muted mb-0">{{$product->rate}}</p>
    </div>
  </div>
  <hr class="">
  <div class="row">
    <div class="col-sm-3">
      <p class="mb-0 font-weight-bold">Category</p>
    </div>
    <div class="col-sm-9">
      <p class="text-muted mb-0">{{$product->category->name}}</p>
    </div>
  </div>
  <hr class="">
  <div class="row">
    <div class="col-sm-3">
      <p class="mb-0 font-weight-bold">Unit</p>
    </div>
    <div class="col-sm-9">
      <p class="text-muted mb-0">{{$product->unit->name}}</p>
    </div>
  </div>
  <hr>
  <div class="row">
    <div class="col-sm-3">
      <p class="mb-0 font-weight-bold">Created date</p>
    </div>
    <div class="col-sm-9">
      <p class="text-muted mb-0">{{$product->created_date}}</p>
    </div>
  </div>
  <hr>

</div>
@endsection