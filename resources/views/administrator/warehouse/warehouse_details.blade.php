@extends('layouts.app')
@section('content')


@if($message = Session::get('success'))
<div id="success-message" class="alert alert-success alert-block">
  <strong> {{ $message}}</strong>
</div>
@endif

<div class="d-flex justify-content-between">

  <button class="btn btn-light"><a href="{{route('branchs.index')}}"> <i class="fa-solid fa-arrow-left fa-lg"></i> Go
      back</a> </button>
  @can('create-warehouse')
  <a href="{{ $branch?'/branchs/'.$branch.'/warehouses/create':route('warehouses.create',$branch)}}"><button
      class="btn btn-dark  mb-3" type="submit">Add Warehouse</button></a>
  @endcan
</div>
<h4>Warehouse Details</h4>
<table class="table align-middle mb-0 bg-white">
  <thead class="bg-light">
    <tr>
      <th>SN</th>
      <th>Name</th>
      <th>Address</th>
      <th>Created date</th>
      <th>Actions</th>
    </tr>
  </thead>

  <tbody>
    @php
    $count = ($warehouses->currentPage()-1)*$warehouses->perPage()+1;
    @endphp

    @foreach ($warehouses as $warehouse )
    <td>
      <p class="fw-normal ms-2">{{$count++}}</p>
    </td>

    <td>
      <p class="fw-bold mb-1">{{$warehouse->name}}</p>
    </td>
    <td>
      <p class="fw-normal mb-1">{{$warehouse->address}}</p>

    </td>

    <td>
      <p class="fw-normal ms-2">{{$warehouse->created_date}}</p>
    </td>
    <td>
      <div class="d-flex">
        @can('view-warehouse')
        <a href="{{ (isset($branch) && $branch) ? '/branchs/'.$branch.'/warehouses/'.$warehouse->id.'/show': route('warehouses.show',$warehouse->id) }}"
          class="  rounded btn  btn-warning px-2 pb-1 pt-1 mr-2 ">View</a>
        @endcan
        @can('edit-warehouse')
        <a href="{{ (isset($branch) && $branch) ? '/branchs/'.$branch.'/warehouses/'.$warehouse->id.'/edit': '/warehouses/'.$warehouse->id.'/edit' }}"
          class="  rounded btn  btn-success px-2 pb-1 pt-1 mr-2 ">Edit</a>
        @endcan
        @can('delete-warehouse')
        <form
          action="{{ (isset($branch) && $branch) ? '/branchs/'.$branch.'/warehouses/'.$warehouse->id.'/destroy': route('warehouses.destroy',$warehouse->id) }}"
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
{{$warehouses->links()}}
@endsection