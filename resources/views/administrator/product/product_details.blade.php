@extends('layouts.app')
@section('content')

@if($message = Session::get('success'))
<div id="success-message" class="alert alert-success alert-block">
  <strong> {{ $message}}</strong>
</div>
@endif

<div class="d-flex justify-content-between">
  <h4>Products Details</h4>
  @can('create-product')
  <a href="{{route('products.create')}}"><button class="btn btn-primary  mb-3" type="submit">Create Product</button></a>
  @endcan
</div>


<table class="table align-middle mb-0 bg-white">
  <thead class="bg-light">
    <tr>
      <th>SN</th>
      <th>Name</th>
      <th>Rate</th>
      <th>Category</th>
      <th>Unit</th>
      <th>Created at</th>
      <th>Actions</th>
    </tr>
  </thead>
  @php
  $count = ($products->currentPage()-1)*$products->perPage()+1;
  @endphp

  <tbody>
    @foreach($products as $product)
    <tr>
      <td>
        <p class="fw-normal ms-2">{{$count++}}</p>
      </td>
      <td>
        <p class="fw-bold mb-1">{{$product->name}}</p>
      </td>
      <td>
        <p class="fw-bold mb-1">{{$product->rate}}$</p>
      </td>

      <td>
        <p class="fw-normal mb-1">{{$product->category->name}}</p>
      </td>
      <td>
        <p class="fw-normal mb-1">{{$product->unit->name}}</p>

      </td>
      <td>
        <p class="fw-normal ms-2">{{$product->created_date}}</p>
      </td>
      <td>
        <div class="d-flex">
          @can('view-product')
          <a href="{{ (isset($branch) && $branch) ? '/branchs/'.$branch.'/products/'.$product->id.'/show': route('products.show',$product->id) }}"
            class="  rounded btn  btn-warning px-2 pb-1  pt-1 mr-2 ">View</a>
          @endcan
          @can('edit-product')
          <a href="{{route('products.edit',$product->id) }}"
            class="  rounded btn  btn-success px-2 pb-1 pt-1 mr-2 ">Edit</a>
          @endcan
          @can('delete-product')
          <form action="{{ route('products.destroy', $product->id) }}" method="POST">
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
{{$products->links()}}
@endsection