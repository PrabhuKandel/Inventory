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


@can('create-role')
<a href="{{route('roles.create')}}"><button class="btn btn-dark  mb-3" type="submit">Create Roles</button></a>
@endcan
<table class="table align-middle mb-0 bg-white">
  <thead class="bg-light">
    <tr>
      <th>SN</th>
      <th>Name</th>
      <th>Actions</th>
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
      <div class="d-flex">
        @can('view-role')
        <a href="{{  route('roles.show',$role->id) }}" class="  rounded btn  btn-warning px-2 pb-1 pt-1 mr-2 ">View</a>
        @endcan
        @can('edit-role')
        <a href="{{route('roles.edit',$role->id)}}" class="  rounded btn  btn-success px-2 pb-1 pt-1 mr-2 ">Edit</a>
        @endcan
        @can('delete-role')
        <form action="{{route('roles.destroy',$role->id)}}" method="POST">
          @csrf
          @method('DELETE')
          <button type="submit" class="rounded btn-danger px-2 pb-1 pt-1">Delete</button>
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