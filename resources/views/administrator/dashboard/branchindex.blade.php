@extends('layouts.app');
@section('content')
<div style="display: grid; grid-template-columns: repeat(3, auto); column-gap: 35px; row-gap:80px;">
  <div class="bg-success   info">
    <p> No of Warehouses </p> <span class="info-no"> {{$warehousesNo}}</span>
  </div>
  <div class="bg-primary  info ">
    <p>No of Products</p> <span class="info-no"> {{$productsNo}}</span>
  </div>
  <div class="bg-info   info">
    <p>No of Suppliers</p> <span class="info-no"> {{$suppliersNo}}</span>
  </div>
  <div class="info" style="background:rgb(192, 1, 147);">
    <p>No of Customers</p> <span class="info-no"> {{$customersNo}}</span>
  </div>
  <div class="bg-danger  info">
    <p>No of purchases</p> <span class="info-no"> {{$inCount}}</span>
  </div>
  <div class="bg-warning  info">
    <p>No of sales</p> <span class="info-no"> {{$outCount}}</span>
  </div>

</div>


<style>
  .info {
    padding: 20px;
    height: 150px;
    border-radius: 20px;
    color: white;
    font-size: 20px;
    display: flex;
    flex-direction: column;

  }

  .info-no {
    text-align: center;
    font-size: 40px;
    font-weight: bold;
  }
</style>
@endsection