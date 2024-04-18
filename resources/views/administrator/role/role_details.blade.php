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



<a href=""><button class="btn btn-dark  mb-3" type="submit">Create Roles</button></a>    
  <table class="table align-middle mb-0 bg-white">
    <thead class="bg-light">
      <tr>
        <th>SN</th>
        <th>Name</th>
        <th>Actions</th>
      </tr>
    </thead>
    @php
    $i=1;
  @endphp

    <tbody>
      
     
      <td > <p class="fw-normal ms-2">{{$i++}}</p></td>
        
        <td>
              <p class="fw-bold mb-1">Role name</p>
        </td>
      <td>
        <div class="d-flex">
          <a href="" class="  rounded btn  btn-success px-2 pb-1 pt-1 mr-2 " >Edit</a>
          <form action="" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="rounded btn-danger px-2 pb-1 pt-1">Delete</button>
        </form>
        </div>
      </td>
     
      </tr>

    </tbody>
  </table>



@endsection
