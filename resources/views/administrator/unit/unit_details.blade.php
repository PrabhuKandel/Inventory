@extends('layouts.app')
@section('content')

@if($message = Session::get('success'))
<div id ="success-message" class="alert alert-success alert-block">
  <strong> {{ $message}}</strong>
</div>
@endif



<a href="{{route('units.create')}}"><button class="btn btn-dark  mb-3" type="submit">Create Unit</button></a>

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
     
      @foreach ($units as $unit )
        
     
      <td > <p class="fw-normal ms-2">{{$i++}}</p></td>
        
        <td>
              <p class="fw-bold mb-1">{{$unit->name}}</p>
        </td>
        <td>
          <p class="fw-normal mb-1">{{$unit->description}}</p>
         
        </td>
        <td >
          <p class="fw-normal ms-2">{{$unit->created_date}}</p>
        </td>
      <td>
        <div class="d-flex">
          <a href="{{route('units.edit',$unit->id) }}" class="  rounded btn  btn-success px-2 pb-1 pt-1 mr-2 " >Edit</a>
          <form action="{{ route('units.destroy', $unit->id) }}" method="POST">
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
