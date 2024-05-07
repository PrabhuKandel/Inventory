@extends('layouts.app')
@section('content')


@if($message = Session::get('success'))
<div id="success-message" class="alert alert-success alert-block">
  <strong> {{ $message}}</strong>
</div>
@endif

<div class="d-flex justify-content-between">
  <h3>Contact Details</h3>
  @can('create-contact')
  <a href="{{route('contacts.create')}}"><button class="btn btn-primary " type="submit"> <i
        class="fa-solid fa-plus"></i> Add Contact</button></a>
  @endcan

</div>
<table class="table table-striped align-middle mt-2 ">
  <thead class="bg-light">
    <tr>
      <th class="fw-bold">SN</th>
      <th class="fw-bold">Name</th>
      <th class="fw-bold">Address</th>
      <th class="fw-bold">Contact Type</th>
      <th class="fw-bold">Created date</th>
      <th class="fw-bold">Actions</th>
    </tr>
  </thead>
  <tbody>
    @php
    $count = ($contacts->currentPage()-1)*$contacts->perPage()+1;
    @endphp
    @foreach ($contacts as $contact )



    <td>
      <p class="fw-normal ms-2">{{$count++}}</p>
    </td>

    <td>
      <p class="fw-bold mb-1">{{$contact->name}}</p>
    </td>
    <td>
      <p class="fw-normal mb-1">{{$contact->address}}</p>

    </td>
    <td>
      <p class=" mb-1">{{$contact->type}}</p>

    </td>
    <td>
      <p class="fw-normal mb-1">{{$contact->created_date}}</p>

    </td>

    <td>
      <div class="d-flex gap-3">
        @can('view-contact')
        <a
          href="{{ (isset($branch) && $branch) ? '/branchs/'.$branch.'/contacts/'.$contact->id.'/show': route('contacts.show',$contact->id) }}"><i
            class="fa-solid fa-magnifying-glass fs-4 text-primary"></i></a>
        @endcan
        @can('edit-contact')
        <a href="{{route('contacts.edit',$contact->id) }}" class="fa-solid fa-pen-to-square fs-4 text-success  "></a>
        @endcan
        @can('delete-contact')
        <form action="{{ route('contacts.destroy', $contact->id) }}" method="POST">
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
{{$contacts->links()}}
</div>


</div>

@endsection