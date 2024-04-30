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

<div class="d-flex justify-content-between">
  <h4>Categories Details</h4>
  @can('create-category')
  <a href="{{route('categories.create')}}"><button class="btn btn-primary  mb-3" type="submit">Create
      category</button></a>
  @endcan
</div>

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
  $count = ($categories->currentPage()-1)*$categories->perPage()+1;
  @endphp

  <tbody>
    @foreach($categories as $category)

    <td>
      <p class="fw-normal ms-2">{{$count++}}</p>
    </td>

    <td>
      <p class="fw-bold mb-1">{{$category->name}}</p>
    </td>
    <td>
      <p class="fw-normal mb-1">{{$category->description}}</p>

    </td>
    <td>
      <p class="fw-normal ms-2">{{$category->created_date}}</p>
    </td>
    <td>
      <div class="d-flex">
        @can('view-category')
        <a href="{{ (isset($branch) && $branch) ? '/branchs/'.$branch.'/categories/'.$category->id.'/show': route('categories.show',$category->id) }}"
          class="  rounded btn  btn-warning px-2 pb-1  pt-1 mr-2 ">View</a>
        @endcan
        @can('edit-category')
        <a href="{{route('categories.edit',$category->id) }}"
          class="  rounded btn  btn-success px-2 pb-1 pt-1 mr-2 ">Edit</a>
        @endcan
        @can('delete-category')
        <form action="{{ route('categories.destroy', $category->id) }}" method="POST">
          @csrf
          @method('DELETE')
          <button type="submit" class="rounded btn-danger px-2 pb-1 pt-1">Delete</button>
        </form>
        @endcan
      </div>
    </td>

    </tr>
    @endforeach
  </tbody>
</table>

{{$categories->links()}}

@endsection