@extends('layouts.app')
@section('content')
<div style="">

  <a
    href="{{isset($branch) && $branch? '/branchs/'.$branch. '/reports/product-availability/generate':' /reports/product-availability/generate'}}">
    <p class="text-dark">Product Availability Report </p>
  </a>
  <a
    href="{{isset($branch) && $branch? '/branchs/'.$branch. '/reports/product-availability-warehouse/generate':' /reports/product-availability-warehouse/generate'}}">
    <p class="text-dark">Product Availability By Warehouse </p>
  </a>
</div>



</style>
@endsection