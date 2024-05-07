@extends('layouts.app')
@section('content')
@if ($message = Session::get('success'))
<div id="success-message" class="alert alert-success alert-block">
  <strong> {{ $message }}</strong>
</div>
@endif

<a href="{{ route('branchs.index') }}"> <i class="fa-solid fa-arrow-left fa-lg">
  </i></a>
<div class="d-flex justify-content-between mt-3">
  <h4>Warehouse Details</h4>
  @can('create-warehouse')
  <a href="{{ $branch ? '/branchs/' . $branch . '/warehouses/create' : route('warehouses.create', $branch) }}"
    class="btn btn-primary"> <i class="fa-solid fa-plus"></i>Add Warehouse</a>
  @endcan
</div>

<table class="table table-striped align-middle mt-2  ">
  <thead class="bg-light">
    <tr>
      <th class="fw-bold">SN</th>
      <th class="fw-bold">Name</th>
      <th class="fw-bold">Address</th>
      <th class="fw-bold">Created date</th>
      <th class="fw-bold">Actions</th>
    </tr>
  </thead>

  <tbody>
    @php
    $count = ($warehouses->currentPage() - 1) * $warehouses->perPage() + 1;
    @endphp

    @foreach ($warehouses as $warehouse)
    <td>
      <p class="fw-normal ms-2">{{ $count++ }}</p>
    </td>

    <td>
      <p class="fw-bold mb-1">{{ $warehouse->name }}</p>
    </td>
    <td>
      <p class="fw-normal mb-1">{{ $warehouse->address }}</p>

    </td>

    <td>
      <p class="fw-normal ms-2">{{ $warehouse->created_date }}</p>
    </td>
    <td>
      <div class="d-flex gap-3">
        @can('view-warehouse')
        <a
          href="{{ isset($branch) && $branch ? '/branchs/' . $branch . '/warehouses/' . $warehouse->id . '/show' : route('warehouses.show', $warehouse->id) }}"><i
            class="fa-solid fa-magnifying-glass fs-4 text-primary"></i></a>
        @endcan
        @can('edit-warehouse')
        <a href="{{ isset($branch) && $branch ? '/branchs/' . $branch . '/warehouses/' . $warehouse->id . '/edit' : '/warehouses/' . $warehouse->id . '/edit' }}"
          class=" fa-solid fa-pen-to-square fs-4 text-success "></a>
        @endcan
        @can('delete-warehouse')
        <form
          action="{{ isset($branch) && $branch ? '/branchs/' . $branch . '/warehouses/' . $warehouse->id . '/destroy' : route('warehouses.destroy', $warehouse->id) }}"
          method="POST">
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
{{ $warehouses->links() }}
@endsection