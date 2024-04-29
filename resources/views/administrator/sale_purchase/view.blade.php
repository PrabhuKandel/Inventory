@extends('layouts.app')
@section('content')
{{-- @dd($branch); --}}

<h3 style=""> Details</h3>
<div class="details-container ml-4" style="text-align:center; margin-top:7%">

  <div class="row ">
    <div class="col-sm-3">
      <p class="mb-0 font-weight-bold">Product Name</p>
    </div>
    <div class="col-sm-9">
      <p class="text-muted mb-0">{{$detail->product_name}}</p>
    </div>
  </div>
  <hr class="">
  <div class="row ">
    <div class="col-sm-3">
      <p class="mb-0 font-weight-bold">Warehouse Name</p>
    </div>
    <div class="col-sm-9">
      <p class="text-muted mb-0">{{$detail->warehouse_name}}</p>
    </div>
  </div>
  <hr class="">
  <div class="row ">
    <div class="col-sm-3">
      <p class="mb-0 font-weight-bold">Contact Name</p>
    </div>
    <div class="col-sm-9">
      <p class="text-muted mb-0">{{$detail->contact_name}}</p>
    </div>
  </div>
  <hr class="">
  <div class="row">
    <div class="col-sm-3">
      <p class="mb-0 font-weight-bold">Quantity</p>
    </div>
    <div class="col-sm-9">
      <p class="text-muted mb-0">{{$detail->quantiy}}</p>
    </div>
  </div>
  <hr>
  <div class="row">
    <div class="col-sm-3">
      <p class="mb-0 font-weight-bold">Transcation date</p>
    </div>
    <div class="col-sm-9">
      <p class="text-muted mb-0">{{$detail->created_at}}</p>
    </div>
  </div>
  <hr>

</div>
@endsection