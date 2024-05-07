@extends('layouts.app')
@section('content')
@if ($message = Session::get('success'))
<div id="success-message" class="alert alert-success alert-block">
  <strong> {{ $message }}</strong>
</div>
@endif



<div class="d-flex justify-content-between">
  <h4>Branch Details</h4>
  @can('create-branch')
  <a href="{{ route('branchs.create') }}" class="btn btn-primary  ">
    <i class="fa-solid fa-plus"></i> Add Branch
  </a>
  @endcan
</div>
<table class="table table-striped align-middle mt-2 ">
  <thead class="">
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
    $count = ($branches->currentPage() - 1) * $branches->perPage() + 1;
    @endphp

    @foreach ($branches as $branch_1)
    @if ($branch_1->type !== 'headquarter')
    <td>
      <p class="fw-normal ms-2">{{ $count++ }}</p>
    </td>

    <td>
      <a href="{{ route('branchs.show', $branch_1->id) }}">
        <p class="fw-bold mb-1">{{ $branch_1->name }}</p>
      </a>
    </td>
    <td>
      <p class="fw-normal mb-1">{{ $branch_1->address }}</p>
    </td>
    <td>
      <p class="fw-normal mb-1">{{ $branch_1->created_date }}</p>
    </td>
    <td>
      <div class="d-flex gap-3">
        @can('view-branch')
        <a href="{{ route('branchs.show', $branch_1->id) }}"><i
            class="fa-solid fa-magnifying-glass fs-4 text-primary"></i></a>
        @endcan
        @can('edit-branch')
        <a href="{{ route('branchs.edit', $branch_1->id) }}" class="fa-solid fa-pen-to-square fs-4 text-success ">
        </a>
        @endcan
        @can('delete-branch')
        <form action="{{ route('branchs.destroy', $branch_1->id) }}" method="POST">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-link text-danger p-0 "><i class="fa-solid fa-trash fs-4"></i></button>
        </form>
        @endcan
      </div>
    </td>
    </tr>
    @endif
    @endforeach
  </tbody>

</table>
{{ $branches->links() }}
@endsection