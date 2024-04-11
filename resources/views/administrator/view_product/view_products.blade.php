@extends('layouts.app')
@section('content')

@if($message = Session::get('success'))
<div id ="success-message" class="alert alert-success alert-block">
  <strong> {{ $message}}</strong>
</div>
@endif




{{-- <div class="border text-primary  pt-2 text-center ">
  <p class="font-weight-bold display-5">No  Branches Yet!</p>
  </div> --}}
 <div class="d-flex flex-row-reverse mb-4">
  {{-- <a href="{{route('products.purchase',$branchId)}}" class="  rounded btn  btn-warning px-2 pb-1 pt-1 mr-2 " >Purchase</a>
  <a href="{{route('products.sale',$branchId)}}" class="  rounded btn  btn-dark px-2 pb-1 pt-1 mr-2 " >Sell</a> --}}
 </div>

  <table class="table align-middle mb-0 bg-white">
    <thead class="bg-light">
      <tr>
        <th>SN</th>
        <th>Name</th>
        <th>Rate</th>
        <th>Unit</th>
        <th>Category</th>
        <th>Quantity</th>
        <th>Warhouse</th>
        <th>Actions</th>
      </tr>
    </thead>
    @php
    $i=1;
  @endphp

    <tbody>
   @foreach ($products as $product )
    

      <td > <p class="fw-normal ms-2">{{$i++}}</p></td>
      <td>
        <p class="fw-bold mb-1">{{$product['name']}}</p>
  </td>
  <td>
    <p class="fw-bold mb-1">{{$product['rate']}}</p>
</td>
        
        <td>
              <p class="fw-normal mb-1">{{$product['category']}}</p>
        </td>
        <td>
          <p class="fw-normal mb-1">{{$product['unit']}}</p>
         
        </td>
        <td class="">
          <p class="fw-normal mb-1">{{$product['quantity']}}</p>
         
        </td>
        <td class="">
          <p class="fw-normal mb-1">{{$product['warehouse']}}</p>
         
        </td>
        
      <td>
        <div class="d-flex ">

          <a href="" class="  rounded btn  btn-success px-2 pb-1 pt-1 mr-2 " >Edit</a>
          <form action="" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="rounded btn-danger px-2 pb-1 pt-1">Delete</button>
        </form>
        </div>
      </td>
     
      </tr>
      @endforeach
    </tbody>
  </table>

@endsection
