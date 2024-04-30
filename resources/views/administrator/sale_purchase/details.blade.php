@extends('layouts.app')
@section('content')
@if($message = Session::get('success'))
<div id="success-message" class="alert alert-success alert-block">
  <strong> {{ $message}}</strong>
</div>
@endif

<div class="d-flex justify-content-between">
  <h4>{{ucfirst($_type)}} Details</h4>
  @canany(['create-purchase','create-sale'])
  <a href="{{ isset($branch) && $branch ? '/branchs/'.$branch.'/'. $_type.'/create': '/'.$_type.'/create' }}">
    @if ($_type == "purchases" && auth()->user()->can('create-purchase') ||$_type == "sales" &&
    auth()->user()->can('create-sale'))
    <button class="btn btn-primary mb-3" type="submit">{{$_type=="purchases"?"Purchase Product":"Sell
      Product"}}</button>
    @endif
  </a>
  @endcanany

</div>

<table class="table align-middle mb-3 bg-white">
  <thead class="bg-light">
    <tr>
      <th>SN</th>
      <th>Contacts</th>
      <th>Date</th>
      <th>Actions</th>
    </tr>
  </thead>

  @php

  $count = ($page - 1) * $perPage + 1;
  @endphp

  <tbody>
    @foreach ($purchasesDetails as $detail )
    <tr>

      <td>
        <p class="fw-normal ms-2">{{$count++}}</p>
      </td>
      <td>
        <p class="fw-bold mb-1">{{$detail->contact_name}}</p>
      </td>
      <td>
        <p class="fw-bold mb-1">{{$detail->created_at}}</p>
      </td>
      <td>
        <div class="d-flex">
          @if ($_type == "purchases" && auth()->user()->can('view-purchase') ||$_type == "sales" &&
          auth()->user()->can('view-sale'))
          <a href="{{ (isset($branch) && $branch) ? '/branchs/'.$branch.'/'.$_type.'/'.$detail->id.'/show':'/'.$_type.'/'.$detail->id.'/show' }}"
            class="  rounded btn  btn-warning px-2 pb-1  pt-1 mr-2 ">View</a>
          @endif

          @if ($_type == "purchases" && auth()->user()->can('edit-purchase') ||$_type == "sales" &&
          auth()->user()->can('edit-sale'))
          <a href="{{ (isset($branch) && $branch) ? '/branchs/'.$branch.'/'.$_type.'/'.$detail->id.'/edit':'/'.$_type.'/'.$detail->id.'/edit' }}"
            class="  rounded btn  btn-success px-2 pb-1 pt-1 mr-2 ">Edit</a>
          @endif


          <form
            action="{{ $branch?'/branchs/'.$branch. '/'.$_type.'/'.$detail->id.'/destroy' :'/'.$_type.'/'.$detail->id.'/destroy'}}"
            method="POST">
            @csrf
            @method('DELETE')
            @if ($_type == "purchases" && auth()->user()->can('delete-purchase') ||$_type == "sales" &&
            auth()->user()->can('delete-sale'))
            <button type="submit" class="rounded btn-danger px-2 pb-1 pt-1">Delete</button>
            @endif
          </form>

        </div>
      </td>

    </tr>
    @endforeach
  </tbody>
</table>

{{-- {{$purchasesDetails->links()}} --}}
@if($total)
<div class="pagination d-flex justify-content-between">
  <div>
    @php
    $start = ($page - 1) * $perPage+1;
    @endphp
    Showing {{$start}} to {{$count-1}} of {{$total}} results
  </div>
  <div class=" d-flex  text-lg ">
    @for ($i = 1; $i <= $totalPages; $i++) <a style="" href=" {{ request()->fullUrlWithQuery(['page' => $i]) }}"
      class="{{ $i == $page ? 'bg-primary text-white' : '' }}">
      <div class="border border-primary rounded" style="width:30px; text-align:center; ">
        {{ $i }}
      </div>
      </a>
      @endfor
  </div>
</div>
@endif

@endsection