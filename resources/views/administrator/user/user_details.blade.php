-@extends('layouts.app')
@section('content')



@if($message = Session::get('success'))
<div id="success-message" class="alert alert-success alert-block">
  <strong> {{ $message}}</strong>
</div>
@endif
<div class="d-flex justify-content-between">
  <h4>User Details</h4>
  <a href="{{route('users.create')}}"><button class="btn btn-primary " type="submit"> <i class="fa-solid fa-plus"></i>
      Add New User</button></a>
</div>

<table class="table table-striped align-middle mt-2 bg-white">
  <thead class="bg-light">
    <tr>
      <th class="fw-bold">SN</th>
      <th class="fw-bold">Name</th>
      <th class="fw-bold">Email</th>
      <th class="fw-bold">Address</th>
      <th class="fw-bold">Roles</th>
      <th class="fw-bold">Created date</th>
      <th class="fw-bold">Actions</th>
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
      <div class="d-flex align-items-start gap-3">
        @can('view-user')
        <a href="{{ (isset($branch) && $branch) ? '/branchs/'.$branch.'/users/'.$user->id.'/show': route('users.show',$user->id) }}"
          class="  fa-solid fa-magnifying-glass fs-4 text-primary "></a>
        @endcan
        @can('edit-user')
        <a href="{{route('users.edit',$user->id) }}" class=" fa-solid fa-pen-to-square fs-4 text-success "></a>
        @endcan
        @can('delete-user')
        <form action="{{ route('users.destroy', $user->id) }}" method="POST">
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
{{$users->links()}}
@endsection