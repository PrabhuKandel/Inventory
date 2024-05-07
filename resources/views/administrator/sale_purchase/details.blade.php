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
    <button class="btn btn-primary " type="submit">{{$_type=="purchases"?"Goods In":"Goods
      Out"}}</button>
    @endif
  </a>
  @endcanany

</div>

<table class="table table-striped align-middle mt-2 bg-white">
  <thead class="bg-light">
    <tr>
      <th class="fw-bold">SN</th>
      <th class="fw-bold">Contacts</th>
      <th class="fw-bold">Date</th>
      <th class="fw-bold">Actions</th>
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
        <p class=" mb-1">{{$detail->created_at}}</p>
      </td>
      <td>
        <div class="d-flex gap-3">
          @if ($_type == "purchases" && auth()->user()->can('view-purchase') ||$_type == "sales" &&
          auth()->user()->can('view-sale'))
          <a
            href="{{ (isset($branch) && $branch) ? '/branchs/'.$branch.'/'.$_type.'/'.$detail->id.'/show':'/'.$_type.'/'.$detail->id.'/show' }}"><i
              class="fa-solid fa-magnifying-glass fs-4 text-primary"></i></a>
          @endif

          @if ($_type == "purchases" && auth()->user()->can('edit-purchase') ||$_type == "sales" &&
          auth()->user()->can('edit-sale'))
          <a href="{{ (isset($branch) && $branch) ? '/branchs/'.$branch.'/'.$_type.'/'.$detail->id.'/edit':'/'.$_type.'/'.$detail->id.'/edit' }}"
            class="fa-solid fa-pen-to-square fs-4 text-success  "></a>
          @endif


          <form
            action="{{ $branch?'/branchs/'.$branch. '/'.$_type.'/'.$detail->id.'/destroy' :'/'.$_type.'/'.$detail->id.'/destroy'}}"
            method="POST">
            @csrf
            @method('DELETE')
            @if ($_type == "purchases" && auth()->user()->can('delete-purchase') ||$_type == "sales" &&
            auth()->user()->can('delete-sale'))
            <button type="submit" class="btn btn-link text-danger p-0 "><i class="fa-solid fa-trash fs-4"></i></button>
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