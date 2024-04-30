-@extends('layouts.app')
@section('content')



@if($message = Session::get('success'))
<div id="success-message" class="alert alert-success alert-block">
  <strong> {{ $message}}</strong>
</div>
@endif
<div class="d-flex justify-content-between">
  <h4>User Details</h4>
  <a href="{{route('users.create')}}"><button class="btn btn-primary  mb-3" type="submit">Add New User</button></a>
</div>

<table class="table align-middle mb-0 bg-white">
  <thead class="bg-light">
    <tr>
      <th>SN</th>
      <th>Name</th>
      <th>Email</th>
      <th>Address</th>
      <th>Roles</th>
      <th>Created date</th>
      <th>Actions</th>
    </tr>
  </thead>

  <tbody>
    @php
    $count = ($users->currentPage()-1)*$users->perPage()+1;
    @endphp

    @foreach ($users as $user )
    @if($user->roles()->first()->name!='Super Admin')


    <td>
      <p class="fw-normal ms-2">{{$count++}}</p>
    </td>

    <td>
      <p class="fw-bold mb-1">{{$user->name}}</p>
    </td>
    <td>
      <p class="fw-normal mb-1">{{$user->email}}</p>
    </td>
    <td>
      <p class="fw-normal mb-1">{{$user->address}}</p>
    </td>
    <td>

      <p class="fw-normal ms-2">{{$user->roles()->first()->name}}</p>

    </td>

    <td>
      <p class="fw-normal ms-2">{{$user->created_date}}</p>
    </td>
    <td>
      <div class="d-flex align-items-start">
        @can('view-user')
        <a href="{{ (isset($branch) && $branch) ? '/branchs/'.$branch.'/users/'.$user->id.'/show': route('users.show',$user->id) }}"
          class="  rounded btn  btn-warning px-2 pb-1  pt-1 mr-2 ">View</a>
        @endcan
        @can('edit-user')
        <a href="{{route('users.edit',$user->id) }}" class="  rounded btn  btn-success px-2 pb-1 pt-1 mr-2 ">Edit</a>
        @endcan
        @can('delete-user')
        <form action="{{ route('users.destroy', $user->id) }}" method="POST">
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
{{$users->links()}}
@endsection