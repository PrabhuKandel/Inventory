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

<div class="d-flex justify-content-between">
  <h4>Units Details</h4>
  @can('create-unit')
  <a href="{{ route('units.create') }}"><button class="btn btn-primary" type="submit"><i class="fa-solid fa-plus"></i>
      Create Unit</button></a>
  @endcan
</div>

<table class="table table-striped align-middle mt-2 bg-white">
  <thead class="bg-light">
    <tr>
      <th class="fw-bold">SN</th>
      <th class="fw-bold">Name</th>
      <th class="fw-bold">Description</th>
      <th class="fw-bold">Created at</th>
      <th class="fw-bold">Actions</th>
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
      <div class="d-flex gap-3">
        @can('view-unit')
        <a href="{{ isset($branch) && $branch ? '/branchs/' . $branch . '/units/' . $unit->id . '/show' : route('units.show', $unit->id) }}"
          class=" "><i class="fa-solid fa-magnifying-glass fs-4 text-primary"></i></a>
        @endcan
        @can('edit-unit')
        <a href="{{ route('units.edit', $unit->id) }}" class=" fa-solid fa-pen-to-square fs-4 text-success "></a>
        @endcan
        @can('delete-unit')
        <form action="{{ route('units.destroy', $unit->id) }}" method="POST">
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
{{ $units->links() }}
@endsection