@extends('layouts.app')
@section('content')


@if($message = Session::get('success'))
<div id ="success-message" class="alert alert-success alert-block">
  <strong> {{ $message}}</strong>
</div>
@endif


@can('create-branch')
<a href="{{route('branchs.create')}}"><button class="btn btn-dark  mb-3" type="submit">Add Branch</button></a>
@endcan

    <h4>Branch Details</h4>
  <table class="table align-middle mb-0 bg-white">
    <thead class="bg-light">
      <tr>
        <th>SN</th>
        <th>Name</th>
        <th>Address</th>
        <th>Created date</th>
        {{-- <th>View</th> --}}
        <th>Actions</th>
      </tr>
    </thead>
    
    <tbody>
      @php
        $i=1;
      @endphp
  
    @foreach ($branches as $branch_1 )
    @if($branch_1->type!=='headquarter')
      <td > <p class="fw-normal ms-2">{{$i++}}</p></td>
        
        <td>
      
          {{-- <a href="{{route('branchs.show',$branch_1->id)}}"> <p class="fw-bold mb-1">{{$branch_1->name}}</p></a> --}}
          <a href="{{route('branchs.show',$branch_1->id)}}"> <p class="fw-bold mb-1">{{$branch_1->name}}</p></a>
        </td>
        <td>
          <p class="fw-normal mb-1">{{$branch_1->address}}</p>
        </td>
        <td>
          <p class="fw-normal mb-1">{{$branch_1->created_date}}</p>
        </td>
        <td>
          <div class="d-felx">
            {{-- <a href="{{route('users.getUsersOfBranch',$branch_1->id)}}" class="  rounded btn  btn-info px-2 pb-1 pt-1 mr-2 " > Users</a> --}}

            {{-- <a href="{{route('products.getProductsOfBranch',$branch_1->id)}}" class="  rounded btn  btn-primary px-2 pb-1 pt-1 mr-2 " > Products</a> --}}
          </div>
   
        <div class="d-flex">
          @can('edit-branch')
          <a href="{{route('branchs.edit',$branch_1->id)}}" class="  rounded btn  btn-dark px-2 pb-1 pt-1 mr-2 " >Edit</a>
          @endcan
          @can('delete-branch')
          <form action="{{ route('branchs.destroy', $branch_1->id) }}" method="POST">
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

@endsection