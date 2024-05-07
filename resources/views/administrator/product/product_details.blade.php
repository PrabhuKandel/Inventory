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
  <a href="{{route('products.create')}}"><button class="btn btn-primary" type="submit"> <i class="fa-solid fa-plus"></i>
      Create Product</button></a>
  @endcan
</div>


<table class="table table-striped align-middle mt-2 bg-white">
  <thead class="bg-light">
    <tr>
      <th class="fw-bold">SN</th>
      <th class="fw-bold">Name</th>
      <th class="fw-bold">Rate</th>
      <th class="fw-bold">Category</th>
      <th class="fw-bold">Unit</th>
      <th class="fw-bold">Created at</th>
      <th class="fw-bold">Actions</th>
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
        <p class=" mb-1">{{$product->rate}}$</p>
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
        <div class="d-flex gap-3">
          @can('view-product')
          <a
            href="{{ (isset($branch) && $branch) ? '/branchs/'.$branch.'/products/'.$product->id.'/show': route('products.show',$product->id) }}"><i
              class="fa-solid fa-magnifying-glass fs-4 text-primary"></i></a>
          @endcan
          @can('edit-product')
          <a href="{{route('products.edit',$product->id) }}" class=" fa-solid fa-pen-to-square fs-4 text-success "></a>
          @endcan
          @can('delete-product')
          <form action="{{ route('products.destroy', $product->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-link text-danger p-0 "><i class="fa-solid fa-trash fs-4"></i></button>
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