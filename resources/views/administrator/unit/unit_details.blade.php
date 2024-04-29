@extends('layouts.app')
@section('content')
@if ($message = Session::get('success'))
<div id="success-message" class="alert alert-success alert-block">
  <strong> {{ $message }}</strong>
</div>
@elseif($message = Session::get('error'))
<div id="success-message" class="alert alert-danger alert-block">
  <strong> {{ $message }}</strong>
</div>
@endif
@can('create-unit')
<a href="{{ route('units.create') }}"><button class="btn btn-dark  mb-3" type="submit">Create Unit</button></a>
@endcan
{{-- <div class="border text-primary  pt-2 text-center ">
  <p class="font-weight-bold display-5">No Branches Yet!</p>
</div> --}}


<table class="table align-middle mb-0 bg-white">
  <thead class="bg-light">
    <tr>
      <th>SN</th>
      <th>Name</th>
      <th>Description</th>
      <th>Created at</th>
      <th>Actions</th>
    </tr>
  </thead>
  @php
  $count = ($units->currentPage() - 1) * $units->perPage() + 1;
  @endphp

  <tbody>

    @foreach ($units as $unit)
    <td>
      <p class="fw-normal ms-2">{{ $count++ }}</p>
    </td>

    <td>
      <p class="fw-bold mb-1">{{ $unit->name }}</p>
    </td>
    <td>
      <p class="fw-normal mb-1">{{ $unit->description }}</p>

    </td>
    <td>
      <p class="fw-normal ms-2">{{ $unit->created_date }}</p>
    </td>
    <td>
      <div class="d-flex">
        @can('view-unit')
        <a href="{{ isset($branch) && $branch ? '/branchs/' . $branch . '/units/' . $unit->id . '/show' : route('units.show', $unit->id) }}"
          class="  rounded btn  btn-warning px-2 pb-1  pt-1 mr-2 ">View</a>
        @endcan
        @can('edit-unit')
        <a href="{{ route('units.edit', $unit->id) }}" class="  rounded btn  btn-success px-2 pb-1 pt-1 mr-2 ">Edit</a>
        @endcan
        @can('delete-unit')
        <form action="{{ route('units.destroy', $unit->id) }}" method="POST">
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
{{ $units->links() }}
@endsection