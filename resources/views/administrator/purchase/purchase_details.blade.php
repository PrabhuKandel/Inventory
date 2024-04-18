@extends('layouts.app')
@section('content')

@if($message = Session::get('success'))
<div id ="success-message" class="alert alert-success alert-block">
  <strong> {{ $message}}</strong>
</div>
@endif



<a href="{{ (isset($branch) && $branch) ? '/branchs/'.$branch.'/purchaseproducts': '/purchaseproducts' }}"><button class="btn btn-dark  mb-3" type="submit">Purchase Product</button></a>

{{-- <div class="border text-primary  pt-2 text-center ">
  <p class="font-weight-bold display-5">No  Branches Yet!</p>
  </div> --}}
 
   
      <table class="table align-middle mb-0 bg-white">
    <thead class="bg-light">
      <tr>
        <th>SN</th>
        <th>Product </th>
        <th>Quantity</th>
        <th>Warehouse</th>
        <th>Customer</th>
        <th>Date</th>
        <th>Actions</th>
      </tr>
    </thead>
    @php
    $i=1;
  @endphp

    <tbody>
      @foreach ($purchasesDetails as $detail )
        
     @if($detail->type == 'purchase')
     <tr>

      <td > <p class="fw-normal ms-2">{{$i++}}</p></td>
      <td>
        <p class="fw-bold mb-1">{{$detail->product->name}}</p>
  </td>
  <td>
    <p class="fw-bold mb-1">{{$detail->quantiy}}</p>
</td>
        
        <td>
              <p class="fw-normal mb-1">{{$detail->warehouse->name}}</p>
        </td>
        <td>
          <p class="fw-normal mb-1">{{$detail->contact->name}}</p>
         
        </td>
        <td >
          <p class="fw-normal ms-2">{{$detail->created_at}}</p>
        </td>
      <td>
        <div class="d-flex">
          <a href="{{route('purchases.edit',$detail->id) }}" class="  rounded btn  btn-success px-2 pb-1 pt-1 mr-2 " >Edit</a>
          <form action="{{ $branch?'/branchs/'.$branch. '/purchases/'.$detail->id.'/destroy' :route('purchases.destroy', $detail->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="rounded btn-danger px-2 pb-1 pt-1">Delete</button>
        </form>
        </div>
      </td>
     
      </tr>
      @endif
      @endforeach
    </tbody>
  </table>

@endsection
