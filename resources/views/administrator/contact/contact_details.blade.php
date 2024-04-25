@extends('layouts.app')
@section('content')


@if($message = Session::get('success'))
<div id="success-message" class="alert alert-success alert-block">
  <strong> {{ $message}}</strong>
</div>
@endif


@can('create-contact')
<a href="{{route('contacts.create')}}"><button class="btn btn-dark  mb-3" type="submit">Add Contact</button></a>
@endcan
{{-- <div class=" container d-flex flex-row justify-content-between"> --}}


  <h3>Contact Details</h3>
  <table class="table align-middle mb-0 bg-white">
    <thead class="bg-light">
      <tr>
        <th>SN</th>
        <th>Name</th>
        <th>Address</th>
        <th>Contact Type</th>
        <th>Created date</th>
        <th>Actions</th>
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
        <p class="fw-bold mb-1">{{$contact->type}}</p>

      </td>
      <td>
        <p class="fw-normal mb-1">{{$contact->created_date}}</p>

      </td>

      <td>
        <div class="d-flex">
          @can('edit-contact')
          <a href="{{route('contacts.edit',$contact->id) }}"
            class="  rounded btn  btn-success px-2 pb-1 pt-1 mb-4 mr-2 ">Edit</a>
          @endcan
          @can('delete-contact')
          <form action="{{ route('contacts.destroy', $contact->id) }}" method="POST">
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
  {{$contacts->links()}}
</div>


</div>

@endsection