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
  <a href="{{route('categories.create')}}"><button class="btn btn-primary " type="submit"> <i
        class="fa-solid fa-plus"></i> Create
      category</button></a>
  @endcan
</div>

<table class="table table-striped align-middle mt-2 bg-white">
  <thead class="bg-light">
    <tr>
      <th class="fw-bold">SN</th>
      <th class="fw-bold">Name</th>
      <th class="fw-bold">Description</th>
      <th class="fw-bold">Created at</th>
      <th class="fw-bold">Actions</th>
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
      <div class="d-flex gap-3">
        @can('view-category')
        <a
          href="{{ (isset($branch) && $branch) ? '/branchs/'.$branch.'/categories/'.$category->id.'/show': route('categories.show',$category->id) }}"><i
            class="fa-solid fa-magnifying-glass fs-4 text-primary"></i></a>
        @endcan
        @can('edit-category')
        <a href="{{route('categories.edit',$category->id) }}" class=" fa-solid fa-pen-to-square fs-4 text-success "></a>
        @endcan
        @can('delete-category')
        <form action="{{ route('categories.destroy', $category->id) }}" method="POST">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-link text-danger p-0 "><i class="fa-solid fa-trash fs-4"></i></button>
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