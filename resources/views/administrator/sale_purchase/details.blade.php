@extends('layouts.app')
@section('content')

@if($message = Session::get('success'))
<div id="success-message" class="alert alert-success alert-block">
  <strong> {{ $message}}</strong>
</div>
@endif


@can('create-purchase|create-sale')
<a href="{{ isset($branch) && $branch ? '/branchs/'.$branch.'/'. $_type.'/create': '/'.$_type.'/create' }}"><button
    class="btn btn-dark  mb-3" type="submit">{{$transcation_type=='purchase'?$transcation_type:"Sell"}}
    Product</button></a>
@endcan
<table class="table align-middle mb-3 bg-white">
  <thead class="bg-light">
    <tr>
      <th>SN</th>
      <th>Product </th>
      <th>Quantity</th>
      <th>Warehouse</th>
      <th>Contacts</th>
      <th>Date</th>
      <th>Actions</th>
    </tr>
  </thead>

  @php
  // $count = ($purchasesDetails->currentPage()-1)*$purchasesDetails->perPage()+1;
  $count = ($page - 1) * $perPage + 1;
  @endphp

  <tbody>
    @foreach ($purchasesDetails as $detail )
    <tr>

      <td>
        <p class="fw-normal ms-2">{{$count++}}</p>
      </td>
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
      <td>
        <p class="fw-normal ms-2">{{$detail->created_at}}</p>
      </td>
      <td>
        <div class="d-flex">
          @can('edit-purchase|edit-sale')
          <a href="" class="  rounded btn  btn-success px-2 pb-1 pt-1 mr-2 ">Edit</a>
          @endcan
          @can('delete-purchase|delete-sale')
          <form
            action="{{ $branch?'/branchs/'.$branch. '/'.$_type.'/'.$detail->id.'/destroy' :'/'.$_type.'/'.$detail->id.'/destroy'}}"
            method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="rounded btn-danger px-2 pb-1 pt-1">Delete</button>
          </form>
          @endcan
        </div>
      </td>

    </tr>
    @endforeach
  </tbody>
</table>

{{-- {{$purchasesDetails->links()}} --}}

<!-- Pagination links -->
<div class="pagination">
  @for ($i = 1; $i <= $totalPages; $i++) <a href="{{ request()->fullUrlWithQuery(['page' => $i]) }}"
    class="{{ $i == $page ? 'active' : '' }}">{{ $i }}</a>
    @endfor
</div>


@endsection