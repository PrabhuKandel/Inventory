@extends('layouts.app')
@section('content')

@if($message = Session::get('success'))
<div id ="success-message" class="alert alert-success alert-block">
  <strong> {{ $message}}</strong>
</div>
@elseif($message = Session::get('error'))
<div id ="success-message" class="alert alert-danger alert-block">
  <strong> {{ $message}}</strong>
</div>
@endif



<a href="{{route('roles.create')}}"><button class="btn btn-dark  mb-3" type="submit">Create Roles</button></a>    
  <table class="table align-middle mb-0 bg-white">
    <thead class="bg-light">
      <tr>
        <th>SN</th>
        <th>Name</th>
        <th>Actions</th>
      </tr>
    </thead>


    <tbody>
      
     @foreach($roles as $role)
      <td > <p class="fw-normal ms-2">{{$loop->iteration}}</p></td>
        
        <td>
              <p class="fw-bold mb-1">{{$role->name}}</p>
        </td>
      <td>
        <div class="d-flex">
          <a href="{{route('roles.edit',$role->id)}}" class="  rounded btn  btn-success px-2 pb-1 pt-1 mr-2 " >Edit</a>
          <form action="{{route('roles.destroy',$role->id)}}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="rounded btn-danger px-2 pb-1 pt-1">Delete</button>
        </form>
        </div>
      </td>
     
      </tr>
@endforeach
    </tbody>
  </table>



@endsection
