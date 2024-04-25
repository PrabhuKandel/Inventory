@extends('layouts.app')
@section('content')
{{-- sucess messaage to when new branch is created --}}
@php
$edit = isset($branch1)&&$branch1?true:false;
@endphp
@if($message = Session::get('success'))
<div id="success-message" class="alert alert-success alert-block">
  <strong> {{ $message}}</strong>
</div>
@endif

<button class="btn btn-light"><a href="{{route('branchs.index')}}"> <i class="fa-solid fa-arrow-left fa-lg"></i> Go
    back</a> </button>


<div class="form-container  " style="padding-left:100px; margin-top:70px">
  <h3 class="ml-5 mb-3">{{$edit?"Edit Branch Details":"Add New Branch" }} </h3>
  @if ($errors->any())
  <div class="  alert alert-danger">
    <ul>
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif
  <form class="ml-5 form-group" action="{{ $edit?route('branchs.update',$branch1->id) :route('branchs.store')}}"
    method="POST">
    @csrf
    @if($edit)
    @method("PUT") @endif
    <div class="form-col ">
      <div class="col-md-4 mb-3">
        <label for="validationDefault01">Branch name</label>
        <input type="text" class="form-control" id="validationDefault01" placeholder="Enter branch name"
          value="{{$edit?$branch1->name:""}}" name="name">
      </div>
      <div class="col-md-4 mb-3">
        <label for="validationDefault02">Branch address</label>
        <input type="text" class="form-control" id="validationDefault02" value="{{$edit?$branch1->address:""}}"
          placeholder="Enter branch address" name="address">
      </div>
      <div class="col-md-4 mb-3">
        <label for="validationDefault02">Date</label>
        <input type="date" id="date" class="form-control" name="created_date"
          value="{{$edit?$branch1->created_date:""}}" pattern="" @if($edit) readonly @endif>

      </div>
      <div class="col-md-4 mb-3 d-flex justify-content-center">
        <button class="btn btn-success " type="submit">{{$edit? "Edit Branch":"Create Branch"}}</button>
      </div>
    </div>
  </form>
</div>

<script>
  let today = new Date();

let formattedDate = today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2);
document.getElementById('date').value = formattedDate;

</script>
@endsection