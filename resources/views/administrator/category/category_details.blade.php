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



<a href="{{route('categories.create')}}"><button class="btn btn-dark  mb-3" type="submit">Create category</button></a>

{{-- <div class="border text-primary  pt-2 text-center ">
  <p class="font-weight-bold display-5">No  Branches Yet!</p>
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
    $i=1;
  @endphp

    <tbody>
      @foreach($categories as  $category)
     
      <td > <p class="fw-normal ms-2">{{$i++}}</p></td>
        
        <td>
              <p class="fw-bold mb-1">{{$category->name}}</p>
        </td>
        <td>
          <p class="fw-normal mb-1">{{$category->description}}</p>
         
        </td>
        <td >
          <p class="fw-normal ms-2">{{$category->created_date}}</p>
        </td>
      <td>
        <div class="d-flex">
          <a href="{{route('categories.edit',$category->id) }}" class="  rounded btn  btn-success px-2 pb-1 pt-1 mr-2 " >Edit</a>
          <form action="{{ route('categories.destroy', $category->id) }}" method="POST">
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
