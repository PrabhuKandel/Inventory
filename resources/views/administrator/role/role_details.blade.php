@extends('layouts.app')
@section('content')

@if($message = Session::get('success'))
<div id="success-message" class="alert alert-success alert-block">
  <strong> {{ $message}}</strong>
</div>
@elseif($message = Session::get('error'))
<div id="success-message" class="alert alert-danger alert-block">
  <strong> {{ $message}}</strong>
</div>
@endif

<div class="d-flex justify-content-between">
  <h4>Roles Details </h4>
  @can('create-role')
  <a href="{{route('roles.create')}}"><button class="btn btn-primary " type="submit"><i class="fa-solid fa-plus"></i>
      Create Roles</button></a>
  @endcan
</div>

<table class="table table-striped align-middle mt-2 bg-white">
  <thead class="bg-light">
    <tr>
      <th class="fw-bold">SN</th>
      <th class="fw-bold">Name</th>
      <th class="fw-bold">Actions</th>
    </tr>
  </thead>
  @php
  $count = ($roles->currentPage()-1)*$roles->perPage()+1;
  @endphp

  <tbody>

    @foreach($roles as $role)
    @if($role->name!="Super Admin")
    <td>
      <p class="fw-normal ms-2">{{$count++}}</p>
    </td>

    <td>
      <p class="fw-bold mb-1">{{$role->name}}</p>
    </td>
    <td>
      <div class="d-flex gap-3">
        @can('view-role')
        <a href="{{  route('roles.show',$role->id) }}"><i
            class="fa-solid fa-magnifying-glass fs-4 text-primary"></i></a>
        @endcan
        @can('edit-role')
        <a href="{{route('roles.edit',$role->id)}}" class="fa-solid fa-pen-to-square fs-4 text-success"></a>
        @endcan
        @can('delete-role')
        <form action="{{route('roles.destroy',$role->id)}}" method="POST">
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
{{$roles->links()}}


@endsection