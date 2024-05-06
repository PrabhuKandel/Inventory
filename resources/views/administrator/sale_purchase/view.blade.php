@extends('layouts.app')
@section('content')
{{-- @dd($branch); --}}

<div class="row">
  <div class="col-sm-3">
    <p class="mb-0 font-weight-bold">Date</p>
    <p class="text-muted mb-0">{{$details[0]->created_date}}</p>
  </div>
  <div class="col-sm-3">
    <p class="mb-0 font-weight-bold">Contact</p>
    <p class="text-muted mb-0">{{$details[0]->contact_name}}</p>
  </div>
</div>
<div class="details-container ml-4" style="text-align:center; margin-top:20px; ">
  <table class="table align-middle mb-3 bg-white">
    <thead class="bg-light">
      <tr>
        <th class=" font-weight-bold">SN</th>
        <th class=" font-weight-bold">Warehouse</th>
        <th class=" font-weight-bold">Product</th>
        <th class=" font-weight-bold">Quantity</th>
        <th class=" font-weight-bold">Amount</th>

      </tr>
    </thead>

    <tbody>
      @php
      $count = 1;
      @endphp
      @foreach ($details as $detail )
      <tr>

        <td>
          <p class="fw-normal ms-2">{{$count++}}</p>
        </td>
        <td>
          <p class="fw-normal ms-2"> {{$detail->product_name}}</p>
        </td>
        <td>
          <p class="fw-normal ms-2"> {{$detail->warehouse_name}}</p>
        </td>
        <td>
          <p class="fw-normal ms-2"> {{$detail->quantity}}</p>
        </td>
        <td>
          <p class="fw-normal ms-2"> {{$detail->amount}}</p>
        </td>
      </tr>
      @endforeach
    </tbody>
    <table>
</div>
@endsection