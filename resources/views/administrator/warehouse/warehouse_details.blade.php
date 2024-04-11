@extends('layouts.app')
@section('content')


@if($message = Session::get('success'))
<div id ="success-message" class="alert alert-success alert-block">
  <strong> {{ $message}}</strong>
</div>
@endif

<div class="d-flex justify-content-between">
  
<button class="btn btn-light"><a href="{{route('branchs.index')}}"> <i class="fa-solid fa-arrow-left fa-lg"></i> Go back</a>  </button>

<a href="{{ !$branch?'/warehouses/create':route('warehouses.create',$branch)}}"><button class="btn btn-dark  mb-3" type="submit">Add Warehouse</button></a>
</div>
    <h4>Warehouse Details</h4>
  <table class="table align-middle mb-0 bg-white">
    <thead class="bg-light">
      <tr>
        <th>SN</th>
        <th>Name</th>
        <th>Address</th>
        <th>Total Products</th>
        <th>Created date</th>
        <th>Actions</th>
      </tr>
    </thead>
    
    <tbody>
      @php
        $i=1;
      @endphp
  
    @foreach ($warehouses  as $warehouse )
      


      <td > <p class="fw-normal ms-2">{{$i++}}</p></td>
        
        <td>
              <p class="fw-bold mb-1">{{$warehouse->name}}</p>
        </td>
        <td>
          <p class="fw-normal mb-1">{{$warehouse->address}}</p>
         
        </td>
        <td >
          <p class="fw-normal ms-2">Total products</p>
        </td>
       
        <td >
          <p class="fw-normal ms-2">{{$warehouse->created_date}}</p>
        </td>
        <td >
        <div class="d-flex">
          <a href="{{route('warehouses.edit',$warehouse->id) }}" class="  rounded btn  btn-success px-2 pb-1 pt-1 mr-2 " >Edit</a>
          <form action="{{ route('warehouses.destroy', $warehouse->id) }}" method="POST">
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