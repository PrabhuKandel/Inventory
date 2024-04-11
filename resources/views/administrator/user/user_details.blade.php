@extends('layouts.app')
@section('content')



@if($message = Session::get('success'))
<div id ="success-message" class="alert alert-success alert-block">
  <strong> {{ $message}}</strong>
</div>
@endif

    <h4>User Details</h4>
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
        $i=1;
      @endphp
  
    @foreach ($users as $user )
      
   

      <td > <p class="fw-normal ms-2">{{$i++}}</p></td>
        
        <td>
              <p class="fw-bold mb-1">{{$user->name}}</p>
        </td>
        <td>
          <p class="fw-normal mb-1">{{$user->email}}</p>
        </td>
        <td>
          <p class="fw-normal mb-1">{{$user->address}}</p>
        </td>
        <td >
          <p class="fw-normal ms-2">Roles</p>
        </td>
       
        <td >
          <p class="fw-normal ms-2">{{$user->created_date}}</p>
        </td>
        <td >
        <div class="d-flex">
          <a href="{{route('users.edit',2) }}" class="  rounded btn  btn-success px-2 pb-1 pt-1 mr-2 " >Edit</a>
          <form action="{{ route('users.destroy', 2) }}" method="POST">
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